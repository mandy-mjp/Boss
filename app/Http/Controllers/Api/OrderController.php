<?php namespace App\Http\Controllers\Api;


use App\Models\GoodsSpec;
use App\Models\OrderBase;
use App\Models\OrderGood;
use Illuminate\Http\Request;
use App\Http\Controllers\SignController;
use Log;
use Pingpp\Charge;
use Pingpp\Pingpp;


class OrderController extends SignController
{

    /**
     * @SWG\Post(path="/v1/order",
     *   tags={"order"},
     *   summary="订单生成",
     *   description="",
     *   operationId="order",
     *  produces={"application/json"},
     *   @SWG\Parameter(
     *     name="uid",
     *     in="query",
     *     description="(签名参数)用户id",
     *     required=true,
     *     type="integer",
     *     @SWG\Schema(ref="uid")
     *   ),
     *   @SWG\Parameter(
     *     name="timestamp",
     *     in="query",
     *     description="(签名参数)时间戳",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(ref="timestamp")
     *   ),
     *   @SWG\Parameter(
     *     name="sign",
     *     in="query",
     *     description="(签名参数)签名",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(ref="sign")
     *   ),
     *   @SWG\Parameter(
     *     name="amount_goods",
     *     in="query",
     *     description="商品金额",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(ref="amount_goods")
     *   ),
     *   @SWG\Parameter(
     *     name="amount_express",
     *     in="query",
     *     description="快递金额",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(ref="amount_express")
     *   ),
     *   @SWG\Parameter(
     *     name="pay_type",
     *     in="query",
     *     description="支付方式(1.支付宝，2.微信)",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(ref="pay_type")
     *   ),
     *  @SWG\Parameter(
     *     name="param_sign",
     *     in="query",
     *     description="参数签名",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(ref="param_sign")
     *   ),
     *   @SWG\Parameter(
     *     name="goods",
     *     in="query",
     *     description="订单商品",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(ref="[{'goods_id':'2','spec_id':'2','price':'10.00','num':'10'},...]")
     *   ),
     *  @SWG\Parameter(
     *     name="receiver_info",
     *     in="query",
     *     description="收货人地址",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(ref="{'id':'137','district_id':'22','mobile':'111347256625','province':'天津','city_id':'21','address':'测试00000001','city':'天津市','district':'和平区','is_default':'1','name':'张三','province_id':'20'}")
     *   ),
     *
     *   @SWG\Response(response=200,description="successful operation"),
     * )
     */
    public function addOrder(Request $request)
    {
        $uid = $request->input('uid', 0);
        $amount_goods = $request->input('amount_goods', 0);
        $amount_express = $request->input('amount_express', 0);
        $pay_type = intval($request->input('pay_type', 0));
        $receiver_info = $request->input('receiver_info', '');
        $goods = $request->input('goods', '');
        $param_sign = $request->input('param_sign', '');
        $param_md5 = md5($uid.$amount_goods.$amount_express.$pay_type.$receiver_info.$goods);

        Log::alert('orderAdd request:' . print_r($request->input(), true));

        $goods = '[{"goods_id":"2","spec_id":"2","price":"10.00","num":"10"}]';
        $goods_arr = json_decode($goods, true);

        //参数不正确
        if ( $param_md5 != $param_sign){
           // return response()->json(array('ret' => self::RET_FAIL, 'msg' => self::PARAMETER_ERROR, 'data' => (object)array()));
        }

        if ($amount_goods == 0 || $goods == '' || empty($goods_arr)) {
            return response()->json(array('ret' => self::RET_FAIL, 'msg' => self::PARAMETER_ERROR, 'data' => (object)array()));
        }


        //预判商品状态
        $spec_id = self::judgeGoodsState($goods_arr);
        if(intval($spec_id) > 0){
            return response()->json(array('ret' => self::RET_FAIL, 'msg' => self::ORDER_GOODS_STATE_ERROR, 'data' =>array('spec_id'=>$spec_id)));
        }

        //预判商品库存
        $spec_id = self::judgeGoodsNum($goods_arr);
        if(intval($spec_id) > 0){
            return response()->json(array('ret' => self::RET_FAIL, 'msg' => self::ORDER_GOODS_NUM_ERROR, 'data' => array('spec_id'=>$spec_id)));
        }


        $OrderBase = new OrderBase();
        $OrderBase->uid = $uid;
        $OrderBase->amount_goods = $amount_goods;
        $OrderBase->amount_express = $amount_express;
        $OrderBase->pay_type = $pay_type;
        $OrderBase->receiver_info = $receiver_info;
        $OrderBase->state = OrderBase::STATE_NO_PAY;
        $OrderBase->save();
        $order_no = date("ymdHis") . sprintf("%03d", substr($OrderBase->id, -3));
        OrderBase::whereId($OrderBase->id)->update(array('order_no' => $order_no));

        //减库存
        self::reduceGoodsNum($order_no, $goods_arr);

        //支付
        $OrderBase = OrderBase::whereOrderNo($order_no)->whereUid($uid)->first();
        $pay_info = self::pingPPChargeCreate($order_no,$OrderBase);
        if(!empty($pay_info)){
            OrderBase::whereId($OrderBase->id)->update(array('pay_info' =>json_encode($pay_info) ));
        }

        $result = array('ret' => self::RET_SUCCESS, 'msg' => '', 'data' => array('id' => strval($OrderBase->id),'order_no'=>strval($order_no),'pay_info'=>$pay_info));
        return response()->json($result);
    }


    private function judgeGoodsState(){
        return 0;
    }

    private function judgeGoodsNum(){
        return 0;
    }

    private function reduceGoodsNum($order_no, $goods_arr){
        foreach($goods_arr as $goods){
            $OrderGood = new OrderGood();
            $OrderGood->order_no = $order_no;
            $OrderGood->goods_id = $goods['goods_id'];
            $OrderGood->spec_id = $goods['spec_id'];
            $OrderGood->price = $goods['price'];
            $OrderGood->num = $goods['num'];
            $OrderGood->save();
        }
    }


    private function pingPPChargeCreate($order_no,$data)
    {

        if ($data->pay_type == 1) {
            $channel = 'alipay';
        } elseif ($data->pay_type == 2) {
            $channel = 'wx';
        }

        Log::alert('订单原数据:' . print_r($data, true));

        $amount = ($data->amount_goods + $data->amount_express + $data->amount_tax - $data->amount_coupon - $data->promotion_amount) * 100;
        //主人指定的补充逻辑，小于1分就付1元。
        if($amount < 1){
            $amount = 100;
        }

        Pingpp::setApiKey('sk_test_PWj5KO9a5W1SrHSuXH0KmjnH');
        //$amount = 1;

        $subject = '订单'.$order_no;

        Log::alert('PAY数据:' . print_r(array(
                'order_no' => $order_no,
                'app' => array('id' => 'app_8CWPaDibjrjTWPyj'),
                'channel' => $channel,
                'amount' => $amount,
                'client_ip' => $_SERVER['REMOTE_ADDR'],
                'currency' => 'cny',
                'subject' =>  $order_no,
                'body' => 'UID' .$data->uid.'-'. $order_no
            ), true));

        $ch = Charge::create(
            array(
                'order_no' => $order_no,
                'app' => array('id' => 'app_8CWPaDibjrjTWPyj'),
                'channel' => $channel,
                'amount' => $amount,
                'client_ip' => $_SERVER['REMOTE_ADDR'],
                'currency' => 'cny',
                'subject' =>  $subject,
                'body' => $subject
            )
        );
        return json_decode($ch, true);
    }

}

