@extends('layout')
<style>
    .goods-nav{font-size:14px;margin-bottom:20px;}
    .goods-nav a{display: inline-block;margin-right: 20px;padding: 5px; text-decoration-line: none !important;}
    .goods-nav .active{border-bottom: 2px solid #4395ff !important;}
</style>
@section("content")
    <div class="pd-20">
        <div class="goods-nav">
            <a class="active">全部</a>
            <a class="">待付款</a>
            <a class="">待发货</a>
            <a href="">待收货</a>
            <a href="">已完成</a>
            <a href="">已关闭</a>
            <div class="search">
                <form class="Huiform" method="post" action="/goods/index" target="_self">

                    <table class="table table-border table-bordered table-bg">
                        <tr >
                            <td>商品名称:<input type="text" class="input-text" style="width:61%" value=""  name="display_name"></td>
                            <td>下单时间：<input type="text" class="input-text" style="width:25%" value=""  name="display_name">到<input type="text" class="input-text" style="width:25%" value=""  name="display_name"></td>
                            <td>订单编号:<input type="text" class="input-text" style="width:57%" value=""  name="display_name"></td>
                            <td>是否有赠品:
                                <select name="" class="input-text">
                                    <option value="">全部</option>
                                    <option value="">有赠品</option>
                                    <option value="">无赠品</option>
                                </select>
                            </td>
                        </tr>

                        <tr >
                            <td>收货人姓名:<input type="text" class="input-text" style="width:250px" value=""  name="display_name"></td>
                            <td>支付方式：
                                <select name=""  class="input-text" style="width:166px" >
                                    <option value="">支付宝支付</option>
                                    <option value="">微信支付</option>
                                </select>
                            </td>
                            <td>收货人手机:<input type="text" class="input-text" style="width:250px" value=""  name="display_name"></td>
                            <td>
                                <button type="reset" class="btn btn-danger">筛选</button>
                                <button type="submit" class="btn btn-success" ><i class="Hui-iconfont">&#xe665;</i>导出</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>


        <table class="table table-border table-bordered table-bg">
            <thead>

            <tr class="text-c">

                <th width="25%">商品</th>
                <th width="5%">数量</th>
                <th>订单金额</th>
                <th width="5%">实付</th>
                <th>状态</th>
                <th>下单时间</th>
                <th>收货人信息</th>
                <th width="10%" colspan="2">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $k => $order)
                <tr class="text-c">
                    <td>
                        <div>
                            <div>订单编号{{$order->order_no}}</div>
                            <div>
                                <img src="" alt="">
                                商品名称
                                价格
                                规格
                            </div>
                        </div>
                    </td>
                    <td>1件</td>

                    <td>{{$order->amount_goods}}</td>
                    <td>{{$order->amount_real}}</td>
                    <td>
                        @if($order->state == \App\Models\OrderBase::STATE_NO_PAY)
                            未付款
                        @endif
                    </td>
                    <td>{{$order->created_at}}</td>
                    <td>
                        {{$order->receiver_info['name']}}</br>
                        {{$order->receiver_info['mobile']}}</br>
                        {{$order->receiver_info['address']}}
                    </td>
                    <td>
                        <a title="查看" href="/orders/lookorders" class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe709;</i>
                        </a>
                        <a title="删除" href="javascript:;" onclick="table_del(this, '菜单', '/perm/menu/delete')" class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6e2;</i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <?php  $orders->render(); ?>
    </div>
@endsection

@section("javascript")
    <script>
        /*
         参数解释：
         title	标题
         url		请求的url
         id		需要操作的数据id
         w		弹出层宽度（缺省调默认值）
         h		弹出层高度（缺省调默认值）
         */
        /*编辑商品*/
        function goods_edit(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*设为厨窗商品*/
        function goods_location(title,url,w,h){
            layer_show(title,url,w,h);
        }

        /*弹出层操作*/
        function confirm_action(message,url){

        }

    </script>
@endsection