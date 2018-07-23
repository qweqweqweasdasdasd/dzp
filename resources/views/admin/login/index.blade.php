@extends('admin/common/master')
@section('title','后台管理登录')
@section('content')
<link href="/admin/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class=""></div>
<div class="loginWraper">
  <div id="loginform" class="loginBox">
    <form class="form form-horizontal" id="form">
    	{{csrf_field()}}
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-xs-8">
          <input id="username" name="username" type="text" placeholder="账户" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-xs-8">
          <input id="password" name="password" type="password" placeholder="密码" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input class="input-text size-L" type="text" placeholder="验证码"  style="width:200px;" name="code">
          <img src="{{captcha_src()}}" onclick="this.src='{{captcha_src()}}' + '?' + Math.random()"></div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
	$('#form').submit(function(event){
		event.preventDefault();
		var shuju = $(this).serialize();
		//ajax
		$.ajax({
			url:'{{url("login")}}',
			data:shuju,
			dataType:'json',
			type:'post',
			headers:{
				'X-CSRF-TOKNE':"{{csrf_token()}}",
			},
			success:function(msg){
				if(msg.code == 0){
					alert(msg.error);
				}else if(msg.code == 1){
					window.location.href = '{{url("/admin/index")}}';
				}
			}
		});
		//console.log(shuju);
	})
</script>
@endsection