@extends('desktop/common/master')
@section('title','密码修改')
@section('content')
<link rel="stylesheet" href="/desktop/css/pwd-style.css">
<div id="wrap">
		<div id="header">
			<div class="header-content clearfix">
				<div class="logo fl"></div>
				<p class="fl">欢迎您：<span>{{$member->mem_no}}</span></p>
				<div class="title fr">
					<ul>
						<li><a href="/">返回首页</a></li>
                        <li><a href="{{url('/user/memcenter')}}">个人中心</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="word">
			<div class="w-wrap"></div>
		</div>
		<div id="main">
			<div class="main-content">
				<div class="turntable clearfix">
					<form action="#" >
                         <p>密码修改</p>
						<ul class='xform-ul'>
                            <input type="hidden" name="mem_id" value="{{$member->id}}">
                            <li>
                                <div class='form-label'>请输入原密码 :</div>
                                <div class='form-input'>
                                    <input type='text' name="oldpwd" placeholder="原密码"/><div style="display: inline" id="tip1"></div>
                                </div>                                
                            </li>
                            <li>
                                <div class='form-label'>请输入新密码 :</div>
                                <div class='form-input'>
                                    <input type='text' name="newpwd" placeholder="长度必须为6-18字符"/><div style="display: inline" id="tip2">
                                </div>
                            </li>                            
                            <li>
                                <div class='form-label'>请再次输入新密码 :</div>
                                <div class='form-input'>
                                    <input type='text' name="newpwdcheck" placeholder="必须和第一次输入一致"/><div style="display: inline" id="tip3">                                       
                                </div>
                            </li>
                            <li class="text-center">
                                <div class="btn-submit"><input type="button" id="btn" value="提交"></div>
                            </li>
                            <li class="text-center">
                                <div id="tip4"></div>
                            </li>
                        </ul>
					</form>
				</div>
			</div>
		</div>
@endsection
@section('my-js')
<!-- <script type="text/javascript" src="desktop/js/pwdJs.js"></script> -->
<script type="text/javascript">
    $('#btn').click(function(evt){
        evt.preventDefault();
        var oldpwd = $('input[name="oldpwd"]').val();
        var newpwd = $('input[name="newpwd"]').val();
        var newpwdcheck = $('input[name="newpwdcheck"]').val();
        var shuju = {oldpwd:oldpwd,newpwd:newpwd,newpwdcheck:newpwdcheck};
        //console.log(shuju);
        //ajax
        $.ajax({
            url:'{{url("/user/password")}}',
            data:shuju,
            type:'post',
            dataType:'json',
            headers:{
                'X-CSRF-TOKEN':'{{csrf_token()}}'
            },
            success:function(data){
                if(data.code == '1'){
                    layer.msg('密码重置ok!',function(){
                        //跳转到登陆
                        window.location.href = "{{url('/')}}";
                    })
                }else if(data.code == '0'){
                    layer.msg(data.error);
                }
            }
        })
    })
</script>
@endsection