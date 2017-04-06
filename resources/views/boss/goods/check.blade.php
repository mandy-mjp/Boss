@extends('layout')
<style>
    .goods-nav{font-size:14px;margin-bottom:20px;}
    .goods-nav a{display: inline-block;margin-right: 20px;padding: 5px; text-decoration-line: none !important;}
    .goods-nav .active{border-bottom: 2px solid #4395ff !important;}
</style>
@section("content")
    <div class="pd-20">
        <div class="goods-nav">
            <a href="{{url('/goods/check/0')}}" class="@if($state == 0) active @endif">待审核</a>
            <a href="{{url('/goods/check')}}" class="@if($state == 1) active @endif">已通过</a>
            <a href="{{url('/goods/check/3')}}" class="@if($state == 3) active @endif">已驳回</a>

            <div class="search mt-20">
                <form class="Huiform" method="get" action="/goods/check/{{$state}}" target="_self">
                    <input type="text" class="input-text" style="width:250px" name="keywords" placeholder="请输入关键字搜索" name="display_name">
                    <button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
                </form>

            </div>
        </div>


        <table class="table table-border table-bordered table-bg">
            <thead>

            <tr class="text-c">

                <th width="40">ID</th>
                <th width="200">商品信息</th>
                <th>所属分馆</th>
                <th width="60">所属分类</th>
                <th>提交时间</th>
                @if($state == 1)
                    <th>审核时间</th>
                @endif
                <th>审核状态</th>
                <th width="160" colspan="2">操作</th>
            </tr>
            </thead>
            <tbody>
                @foreach($goods_list as $goods)
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

                        <td>{{$goods->pavilion}}</td>
                        <td>{{$goods->category_id}}</td>
                        <td>{{$goods->created_at}}</td>
                        @if($state == 1)
                            <td>{{$goods->updated_at}}</td>
                        @endif
                        <td>{{$goods->state}}

                        </td>
                        <td>
                            <a href="">查看</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {!! $goods_list->render() !!}

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