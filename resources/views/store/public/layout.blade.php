<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/lib/html5.js"></script>
    <script type="text/javascript" src="/lib/respond.min.js"></script>
    <script type="text/javascript" src="/lib/PIE_IE678.js"></script>
    <![endif]-->
    <link href="/css/H-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
    <link href="/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>{{$title}}</title>
</head>
<body>



@yield("nav")
@yield("content")
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/js/H-ui.js"></script>
<script type="text/javascript" src="/js/H-ui.admin.js"></script>
<script type="text/javascript" src="/own/js/common.js"></script>
@yield("javascript")
<script type="text/javascript">

</script>
</body>
</html>