@extends('layout_pop')

@section("content")
    <div>
        <div>订单详情</div>
        <div>
            <div>订单信息</div>
            <div>
                <table>
                    <tr>
                        <td>订单编号: 345343</td>
                        <td>订单金额： 20.00</td>
                    </tr>
                    <tr>
                        <td>商品名称: 123</td>
                        <td>实付: $20.00</td>
                    </tr>
                    <tr>
                        <td>零售价：￥20.00 建议零售价：￥30.00</td>
                        <td>付款时间： </td>
                    </tr>
                    <tr>
                        <td>规格: 一盒装</td>
                        <td>付款方式： 微信支付</td>
                    </tr>
                    <tr rowspan="2">
                        <td>数量：1</td>
                    </tr>
                </table>
            </div>

            <div>
                <div><label>收货人信息 </label>：永乐 13418663838 广东省深圳市南山区科技园蚂蚁邦创业中心226</div>
                <div><label>物流公司</label>：</div>
                <div>
                    <label>物流单号</label>：
                    <a href="">手动查询物流信息</a>
                </div>
            </div>

            <div>
                <label>买家留言</label>
                <textarea></textarea>
            </div>

            <div>
                <p>售后信息</p>
                <div>
                    状态：待处理  申请时间：4395390
                </div>
                <div>
                    售后原因：4363453535
                    <img src="">
                </div>

            </div>

            <input type="button" value="通过审核">
            <input type="button" value="驳回申请">
        </div>

    </div>



@section("javascript")
<script>
$(function(){
	$("#form-perm-user-edit").Validform({
        tiptype:2,
        ajaxPost:true,
        postonce:true,
        callback:function(data){
            if(data.ret == 'yes') {
                layer.alert(data.msg,{icon:1,time:1000});
                parent.location.replace(parent.location.href);
            } else if(data.ret == 'no') {
                layer.alert(data.msg,{icon:2,time:5000});
            } else {
                layer.alert('添加失败', {icon:2,time:5000});
            }
        }
    });
});
</script>
@endsection