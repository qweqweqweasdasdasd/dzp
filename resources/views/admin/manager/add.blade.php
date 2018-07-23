@extends('admin/common/master')
@section('title','管理员添加')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">角色：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
			<select class="select" name="role_id" size="1">
				@foreach($role as $k=>$v)
				<option value="{{$k}}">{{$v}}</option>
				@endforeach
			</select>
			</span> </div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">管理员：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="" id="username" name="username">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">初始密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  value="" id="password" name="password">
		</div>
	</div>
	<br/>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;确认提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>
@endsection
@section('my-js')
<script type="text/javascript">
	$('#form-admin-add').submit(function(evt){
		evt.preventDefault();
		var shuju = $(this).serialize();
		//ajax
		$.ajax({
			url:'{{url("/manager/add")}}',
			data:shuju,
			dataType:'json',
			type:'post',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(msg){
				if(msg.code == 1){
					layer.alert('添加管理员成功!',function(){
						parent.window.location.href = parent.window.location.href;
						layer_close();
					})
				}else if(msg.code == 0){
					layer.msg(msg.error);
				}
			}
		});
	});
</script>
@endsection