<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\GenController;
use App\Models\ConfCategory;
use App\Models\ConfPavilion;
use App\Models\GoodsBase;
use App\Models\GoodsDesc;
use App\Models\GoodsExt;
use App\Models\GoodsGift;
use App\Models\GoodsImage;
use App\Models\GoodsOptLog;
use App\Models\GoodsSpec;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
class GoodsController extends GenController
{
    /**
     * 商品列表页
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goods = GoodsBase::paginate(5);
        foreach ($goods as $good){
            $category = ConfCategory::whereId($good->category_id)->first();
            $good->category_name = $category->name;
        }
        return view('store.goods.index')->with(['goods'=>$goods,'title'=>'易游购供应商平台']);
    }

    /**
     * 创建表单
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取分类
        $conf_categories = ConfCategory::all();
        //获取场馆
        $pavilions = ConfPavilion::all();
        return view('store.goods.create')->with('title','易游购供货商平台')->with(['pavilions'=>$pavilions,'conf_categories'=>$conf_categories]);
    }

    /**
     * 添加商品
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        //验证表单
        $validator=Validator::make(
            array(
                'category_id'   =>  Input::get('category_id'),
                'title'         =>  Input::get('title'),
                'cover'         =>  Input::get('cover')
            ),
            array(
                'category_id'   =>  'required',
                'title'         =>  'required',
                'cover'         =>  'required'
            ),
            array(
                'category_id'   =>  '请选择商品分类',
                'title'         =>  '请输入商品名称',
                'cover'         =>  '请上传商品封面'
            )
        );
        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();//输出错误信息
        }
        //存入商品goods_base
        $goods_base = [
            'title'         =>  Input::get('title'),
            //TODO::供应商ID 从Auth中取 'supplier_id'   =>  Input::get('supplier_id'),
            'category_id'   =>  Input::get('category_id'),
            'cover'         =>  Input::get('cover'),
            'pavilion'      =>  Input::get('pavilion')
        ];
        $goods_base_obj = GoodsBase::create($goods_base);
        $goods_id = $goods_base_obj->id;
        //循环 存储商品详情goods_desc
        foreach ($data['desc_name'] as $desc_key => $desc_val){
            $goods_desc = [
                'goods_id'      =>  $goods_id,
                'name'          =>  $desc_val,
                'description'   =>  $data['desc_description'][$desc_key]
            ];
            //TODO::返回的goods_desc 对象是否有用??
            $goods_desc_obj = GoodsDesc::create($goods_desc);
        }
        //商品扩展goods_ext
        $goods_ext = [
            'goods_id'          =>  $goods_id,
            'important_tips'    =>  Input::get('important_tips'),
            'send_out_address'  =>  Input::get('send_out_address'),
            'send_out_desc'     =>  Input::get('send_out_desc'),
            'product_area'      =>  Input::get('product_area'),
            'shelf_life'        =>  Input::get('shelf_life'),
            'pack'              =>  Input::get('pack'),
            'store'             =>  Input::get('store'),
            'express_desc'      =>  Input::get('express_desc'),
            'sold_desc'         =>  Input::get('sold_desc'),
            'level'             =>  Input::get('level'),
            'product_license'   =>  Input::get('product_license'),
            'company'           =>  Input::get('company'),
            'dealer'            =>  Input::get('dealer'),
            'food_addiitive'    =>  Input::get('food_addiitive'),
            'food_burden'       =>  Input::get('food_burden'),
            'address'           =>  Input::get('address'),
            'remark'            =>  Input::get('remark')
        ];
        //TODO::返回的goods_ext 对象是否有用??
        $goods_ext_obj = GoodsExt::create($goods_ext);
        // 商品图片goods_images
        foreach ($data['images'] as $image_val){
            $goods_images = [
                'goods_id'  =>  $goods_id,
                'name'      =>  $image_val
            ];
            //TODO::返回的goods_images 对象是否有用??
            $goods_images_obj = GoodsImage::create($goods_images);
        }

        // 商品 属性/规格 goods_spec
        foreach ($data['spec_name'] as $spec_key => $spec_val){
            $goods_spec = [
                'goods_id'      =>  $goods_id,
                'name'          =>  $spec_val,
                'pack_num'      =>  $data['pack_num'][$spec_key],
                'num'           =>  $data['num'][$spec_key],
                //'num_sold'      =>  $data['num_sold'][$spec_key],//已售数量
                'weight'        =>  $data['weight'][$spec_key],
                'weight_net'    =>  $data['weight_net'][$spec_key],
                'long'          =>  $data['long'][$spec_key],
                'wide'          =>  $data['wide'][$spec_key],
                'height'        =>  $data['height'][$spec_key],
                'price'         =>  $data['price'][$spec_key],
                'price_buying'  =>  $data['price_buying'][$spec_key],
                //'platform_fee'  =>  $data['platform_fee'][$spec_key],//平台服务费
                //'guide_rate'    =>  $data['guide_rate'][$spec_key],//导游分成
                //'travel_agency_rate'  =>  $data['travel_agency_rate'][$spec_key],//旅行社分成
                //'express_fee_mode'    =>  $data['express_fee_mode'][$spec_key],
            ];
            //TODO::返回的goods_spec 对象是否有用??
            $goods_spec_obj = GoodsSpec::create($goods_spec);
        }

        //如果有赠品,存储赠品goods_gift
        if($data['gift_id']){
            foreach ($data['gift_id'] as $gift_val){
                $goods_gift = [
                    'goods_id' =>  $goods_id,
                    'gift_id'  =>  $gift_val
                ];
                //TODO::返回的goods_gift 对象是否有用??
                $goods_gift_create = GoodsGift::create($goods_gift);
            }

        }
        //写入操作日志goods_opt_log
        $goods_opt_log = [
            'type'      =>  1,
            'uid'       =>  123,
            'gid'       =>  $goods_id,
            'content'   =>  '日志内容'
        ];
        //TODO::返回的goods_opt_log 对象是否有用??
        $goods_opt_log_obj = GoodsOptLog::create($goods_opt_log);
        //TODO::是否需要判断，进行跳转
        //return Redirect::to('index');

    }

    /**
     * 商品详情页
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 商品编辑 表单页
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 商品更新
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除商品
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 商品图片上传
     */
    function upload(){
        return response()->json(['img'=>$this->uploadToQiniu()]);
    }
    function gift(){
        //获取商品
        $goods = GoodsBase::all();
        return view('store.goods.gift')->with(['goods'=>$goods]);
    }
    function gift_guide($id){
        $guide = GoodsSpec::whereGoodsId($id)->get();
        return response()->json(['guide'=>$guide]);
    }
    function gift_store(){
        //接收赠品id及规格
        $gift_id = Input::get('gift_id');
        $guide_id = Input::get('guide');
        if(!$gift_id || !$guide_id){
            return response()->json(['ret'=>'no','msg'=>'请选择商品和规格']);
        }
        //获取赠品信息
        $goods = GoodsBase::whereId($gift_id)->first();
        $goods->spec = GoodsSpec::whereId($guide_id)->first();
        return response()->json(['ret'=>'yes','goods'=>$goods,'msg'=>'赠品添加成功']);
    }
    function spec(){
        $data = ['image'=>Input::get('image'),'description'=>Input::get('description')];
        return response()->json(['ret'=>'yes','data'=>$data,'msg'=>'商品详情添加成功']);
    }

}
