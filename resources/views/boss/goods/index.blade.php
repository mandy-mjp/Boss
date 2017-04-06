@extends('layout')
<script type="text/javascript" src="{{asset('lib/clipboard/clipboard.min.js')}}">

</script>
<style>
    .goods-nav{font-size:14px;}
    .goods-nav a{display: inline-block;margin-right: 20px;padding: 5px; text-decoration-line: none !important;}
    .goods-nav .active{border-bottom: 2px solid #4395ff !important;}
    .search{margin: 20px auto;}
    .input-text{width: auto !important; margin:0px 15px;}
</style>
@section("content")
    <div class="pd-20">
        <div class="goods-nav">
            <a href="{{url('/goods/index/1')}}" class="@if($state == 1) active @endif">出售中</a>
            <a href="{{url('/goods/index/location')}}" class="@if($state == 'location') active @endif">橱窗商品</a>
            <a href="{{url('/goods/index/2')}}" class="@if($state == 2) active @endif">已下架</a>
        </div>



        <div class="search">
            <form class="Huiform" method="post" action="/goods/index" target="_self">

                <table class="table table-border table-bordered table-bg">
                    <thead>

                    <tr width="40%" class="text-r">
                        <td>商品名称:<input type="text" class="input-text title" value="{{@$input['title']}}" name="title"></td>
                        <td>商品类目:
                            <select name="category_id" class="input-text">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" @if($category->id == @$input['category_id']) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>橱窗位置:
                            <select name="location"  class="input-text">
                                <option value="1">首页精选1</option>
                                <option value="2">首页精选2</option>
                                <option value="3">首页精选3</option>
                            </select>
                        </td>

                    </tr>
                    </thead>
                    <tbody>
                    <tr width="40%" class="text-r">
                        <td>供应商:<input type="text" class="input-text" value="" name="supplier"></td>
                        <td>总销量:<input type="text" class="input-text" value="{{@$input['num_sold_start']}}" name="num_sold_start">到<input type="text" value="{{@$input['num_sold_end']}}" class="input-text" name="num_sold_end"></td>
                        <td></td>
                    </tr>
                    <tr width="20%" class="text-r">
                        <td colspan="3">
                            <button type="reset" class="btn btn-danger">清空条件</button>
                            <button type="submit" class="btn btn-success" ><i class="Hui-iconfont">&#xe665;</i>搜索</button></td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>








        <table class="table table-border table-bordered table-bg">
            <thead>

            <tr class="text-c">

                <th >ID</th>
                <th >商品信息</th>
                <th >零售价（元）</th>
                <th >库存</th>
                <th >总销量</th>
                <th >橱窗位置</th>

                <th colspan="2">操作</th>
            </tr>
            </thead>
            <tbody>
            @forelse($goodsList as $goods)
                <tr class="text-c">
                    <td>{{$goods->id}}</td>
                    <td>
                        <div class="row">
                            <div class="col-md-3 text-r">
                                <img src="{{asset('images/user.png')}}" alt="" width="60" height="60"/>
                            </div>
                            <div class="col-md-9">
                                <div class="row"><span class="c-blue"> {{$goods->title}}</span></div>
                                <div class="row"><span class="c-red">供货价:{{$goods->priceBuying}}</span></div>
                            </div>

                        </div>
                        </td>

                    <td>{{$goods->price}}</td>
                    <td>{{$goods->num}}</td>
                    <td>{{$goods->num_sold}}</td>
                    <td>{{$goods->location}}</td>
                    <td width="200" class="c-blue">
                        <div class="col-md-6">
                            <div class="row"><a href="{{url('goods/edit',$goods->id)}}" >编辑</a></div>
                            <div class="row"><a onclick="copy_link({{$goods->id}})" id="copy-link-{{$goods->id}}" data-clipboard-text="{{url('goods/show',$goods->id)}}">复制链接</a></div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                @if($goods->location)
                                    <a onclick="confirm_action('确定取消厨窗商品吗?取消后正常售卖','{{url('/goods/action/location_cancel',$goods->id)}}')">取消厨窗商品</a>
                                @else
                                    <a onclick="dialogs('商品信息','{{url('goods/location_fix',$goods->id)}}',600,450)">设为厨窗商品</a>
                                @endif</div>
                            <div class="row">
                                @if($goods->state == 1)
                                    <a onclick="confirm_action('确定需要强制下架吗?下架后该商品将停止正常售卖','{{url('/goods/action/goods_down',$goods->id)}}')">强制下架</a>
                                @elseif($goods->state == 2)
                                    <a onclick="confirm_action('确定上架该商品吗?','{{url('/goods/action/goods_up',$goods->id)}}')">上架</a>
                                @endif

                            </div>
                        </div>




                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
        <div class="page">{!!$goodsList->render()!!}</div>
    </div>
@endsection
@section("javascript")
    <script>
        /*
         参数解释：
         title	标题
         url	请求的url
         id		需要操作的数据id
         w		弹出层宽度（缺省调默认值）
         h		弹出层高度（缺省调默认值）
         */
        /*弹窗操作*/
        function dialogs(title,url,w,h){
            layer_show(title,url,w,h);
        }


        /*弹出层操作*/
        function confirm_action(message,url){
            layer.confirm(message,function(index){
                $.get(url,function (data) {
                    if(data.msg){
                        layer.msg(data.msg,{icon:1,time:1000});
                    }
                })
            });
        }

        function copy_link(goods_id)
        {
            var clipboard = new Clipboard('#copy-link-'+goods_id);//实例化

            //复制成功执行的回调，可选
            clipboard.on('success', function(e) {
                alert('商品链接复制成功');
            });
        }

    </script>
@endsection
