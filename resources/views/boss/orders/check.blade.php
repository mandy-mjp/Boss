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
            <a href="">待付款</a>
            <a href="">待发货</a>
            <a href="">待收货</a>
            <a href="">已完成</a>
            <a href="">已关闭</a>
            <div class="float-r">
                <form class="Huiform" method="get" action="/perm/menu" target="_self">
                    <label>商品名称</label><input type="text" class="input-text" style="width:250px" value=""  name="display_name">
                    <label>订单编号</label><input type="text" class="input-text" style="width:250px" value=""  name="display_name">
                    <label>收件人手机</label><input type="text" class="input-text" style="width:250px" value=""  name="display_name">
                    <label>收件人姓名</label><input type="text" class="input-text" style="width:250px" value=""  name="display_name">
                    <button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 筛选</button>
                </form>

            </div>
        </div>


        <table class="table table-border table-bordered table-bg">
            <thead>

            <tr class="text-c">

                <th width="150">商品
                </th>
                <th width="50">数量</th>
                <th>订单金额）</th>
                <th width="60">实付</th>
                <th>状态</th>
                <th>下单时间</th>
                <th>收货人信息</th>
                <th width="50" colspan="2">操作</th>
            </tr>
            </thead>
            <tbody>

                <tr class="text-c">
                    <td>
                        <div>订单编号</div>
                        <div>
                            <div><img src="" alt=""/></div>
                            <div>商品名</div>
                            <div>价格</div>
                            <div>规格</div>

                        </div>
                    </td>
                    <td></td>

                    <td>订单金额</td>
                    <td>实付</td>
                    <td>状态</td>
                    <td>下单时间</td>
                    <td>收货人信息</td>
                    <td>
                        <a title="编辑" href="javascript:;" onclick="admin_permission_edit('菜单编辑','/perm/menu//update','','510')" class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        <a title="删除" href="javascript:;" onclick="table_del(this, '菜单', '/perm/menu//delete')" class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6e2;</i>
                        </a>
                    </td>
                </tr>

            </tbody>
        </table>

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