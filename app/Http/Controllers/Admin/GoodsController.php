<?php

namespace App\Http\Controllers\Admin;

use App\Models\ConfCategory;
use App\Models\ConfPavilion;
use App\Models\GoodsBase;
use App\Models\GoodsCategory;
use App\Models\GoodsDesc;
use App\Models\GoodsExt;
use App\Models\GoodsGift;
use App\Models\GoodsImage;
use App\Models\GoodsSpec;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class GoodsController extends BaseController
{
    /* $offset 页码值*/
    private $offset = 5;

    /**
     * 显示列表页，搜索页
     *
     * @return \Illuminate\Http\Response
     */
    public function index($state = 1)
    {
        //声明允许接收参数
        $states = [1, 'location', 2];
        if (in_array($state, $states)) {
            if ($state == 'location') {
                $goods = GoodsBase::whereLocation(1);
            } else {
                $goods = GoodsBase::whereState($state);
            }
            //接收参数
            $title = Input::get('title');
            $category_id = Input::get('category_id');
            $location = Input::get('location');
//          $supplier       = Input::get('supplier');
            $num_sold_start = Input::get('num_sold_start');
            $num_sold_end = Input::get('num_sold_end');
            //判断参数
            if (!is_null($title)) {
                $goods = $goods->where('title', 'like', '%' . $title . '%');
            }
            if (!is_null($category_id)) {
                $goods = $goods->whereCategoryId($category_id);
            }
            if (!is_null($location)) {
                $goods = $goods->whereLocation($location);
            }
//            if(!is_null($supplier)){
//                //TODO::供应商处理 获取符合条件的供应商
//                $suppliers=[];
//                $goods = $goods->whereIn('supplier_id',$suppliers);
//            }
            if (!is_null($num_sold_start) && !is_null($num_sold_end)) {
                $goods = $goods->whereBetween('num_sold', [$num_sold_start, $num_sold_end]);
            }

            //获取数据
            $goodsList = $goods->paginate($this->offset);
            //字段拼接
            foreach ($goodsList as $goods) {
                $goodsSpec = GoodsSpec::whereGoodsId($goods->id)->first();
                $goods->price = $goodsSpec->price;
                $goods->priceBuying = $goodsSpec->price_buying;
            }
            //获取分类
            $categories = ConfCategory::all();
            //TODO::获取厨窗
            //$chuchuang = Chuchuang::all();
            return view('boss.goods.index')->with(['goodsList' => $goodsList, 'state' => $state, 'categories' => $categories, 'input' => Input::all()]);
        } else {
            return view('errors.404');
        }

    }

    /**
     *审核列表页
     */
    public function check($state = 1)
    {
        //声明允许接收参数 0未审核 3驳回
        $states = [0, 1, 3];
        if (in_array($state, $states)) {
            if ($state != 1) {
                $goods = GoodsBase::whereState($state);
            } else {
                $goods = GoodsBase::whereIn('state', [1, 2]);
            }
            //搜索
            $keywords = Input::get('keywords');
            if (!is_null($keywords)) {
                $goods = $goods->where('title', 'like', '%' . $keywords . '%')->paginate($this->offset);
            } else {
                $goods = $goods->paginate($this->offset);
            }
            //获取关联数据
            //foreach ($goods as $val){//...}
            return view('boss.goods.check')->with(['state' => $state, 'goods_list' => $goods]);
        } else {
            return view('errors.404');
        }

    }

    /**
     *ajax快捷提交动作
     */
    public function action($action, $id)
    {
        switch ($action) {
            //取消厨窗
            case 'location_cancel':
                $return = GoodsBase::whereId($id)->update(['location' => 0]);
                break;
            //商品上架
            case 'goods_up':
                $return = GoodsBase::whereId($id)->update(['state' => 1]);
                break;
            //商品下架
            case 'goods_down':
                $return = GoodsBase::whereId($id)->update(['state' => 2]);
                break;
        }
        if ($return) {
            return response()->json(['msg' => '操作成功']);
        }
    }

    /**
     * 设为厨窗
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function location_fix($id)
    {
        //获取商品信息
        $goods = GoodsBase::whereId($id)->first();
        //TODO::获取厨窗

        return view('boss.goods.location_fix')->with('goods', $goods);
    }
    function location_edit(){
        //设为厨窗
        //$return = GoodsBase::whereId($id)->update(['location' => 1]);
        return response()->json(['ret'=>'yes']);

    }

    /**
     * 编辑商品
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //获取商品信息
        $goods = GoodsBase::whereId($id)->first();
        //获取轮播图
        $goods->images = GoodsImage::whereGoodsId($goods->id)->get();
        //获取分类
        $goods->conf_categories = ConfCategory::all();
        //运营分类
        $goods_categories = GoodsCategory::whereGoodsId($goods->id)->get();
        //dd($goods_categories);
        foreach ($goods_categories as $goods_category) {
            $category[] = $goods_category->category_id;
        }
        $goods->goods_category = [];
        if(isset($category)){
            $goods->goods_category = $category;
        }

        //获取场馆
        $goods->pavilions = ConfPavilion::all();
        //获取详情、属性、规格、赠品
        $goods->desc = GoodsDesc::whereGoodsId($goods->id)->get();
        $goods->ext  = GoodsExt::whereGoodsId($goods->id)->first();
        $goods->spec = GoodsSpec::whereGoodsId($goods->id)->get();
        $goods->gift = GoodsGift::whereGoodsId($goods->id)->get();

        //dd($goods->ext->toArray());
        return view('boss.goods.edit')->with(['goods' => $goods]);
    }

    /**
     *获取商品信息
     */
    public function get_goods($goods_id)
    {

    }

    /**
     * 更新商品
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
    }

    /**
     * 上传文件
     *
     */
    function upload()
    {
        return response()->json(['img' => $this->uploadToQiniu()]);
    }

}
