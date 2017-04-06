<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Models\OrderBase;
use App\Models\GoodsBase;
use App\Models\OrderGood;
use App\Models\GoodsSpec;

class OrderController extends BaseController
{
    //待审核
   public function check(){

       return view('boss.orders.check');

   }

    //待退款
    public function refund(){

        return view('boss.orders.refund');

    }

    //全部订单
    public function allOrders()
    {
        $orders = OrderBase::orderBy('created_at');
        $orders = $orders->paginate(5);
        foreach($orders as $key => $order){
            $orderGoods = OrderGood::whereOrderNo($order->order_no)->get();
            $order->receiver_info = json_decode($order->receiver_info,true);
            $tmp = array();
            foreach( $orderGoods as $orderGood){
                $goodsBase = GoodsBase::where('id',$orderGood->goods_id)->first();
                $goodsSpec=GoodsSpec::where('id',$orderGood->spec_id)->first();
                $orderGood->cover = $goodsBase->cover;
                $orderGood->title = $goodsBase->title;
                $orderGood->packname =$goodsSpec->name;
                $tmp[] = $orderGood;
            }


            $order->tmp = $tmp;

        }

        return view('boss.orders.allorders',['orders' => $orders]);

        }



    public function editOrders(){
        //判断权限


        return view('boss.orders.order_edit');

    }

}
