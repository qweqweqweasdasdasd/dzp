<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet" href="/desktop/css/public.css">
<link rel="stylesheet" href="/desktop/css/style.css">
<link rel="stylesheet" href="/desktop/iconfont/iconfont.css">
<title>@yield('title')</title>
</head>
<body>
	@yield('content')
</body>
	<script type="text/javascript" src="/desktop/js/chajian/jquery.min.js"></script>
	<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
	
    <script type="text/javascript" src="/desktop/js/control.js"></script>
    <script type="text/javascript" src="/desktop/js/chajian/scroll.js"></script>
    @yield('my-js')
</html>