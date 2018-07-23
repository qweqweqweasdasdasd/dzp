@extends('admin/common/master')
@section('title','编辑权限节点')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
		<input type="hidden" name="ps_id" value="{{$info->ps_id}}"/>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">权限名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$info->ps_name}}" placeholder="例: 权限名称" id="ps_name" name="ps_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">所属父权限：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" >
				<select class="select" name="ps_pid" size="1">
					@foreach($data as $v)
					<option value="{{$v['ps_id']}}" 
					@if($info->ps_pid == $v['ps_id'])
					selected
					@endif
					>{{str_repeat('&nbsp;&nbsp;&nbsp;',$v['ps_level']) . $v['ps_name']}}</option>
					@endforeach
				</select>
				</span> </div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">控制器：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$info->ps_c}}" placeholder="例: Permission" id="ps_c" name="ps_c">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">操作方法：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$info->ps_a}}" placeholder="例: index" id="ps_a" name="ps_a">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">路由：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text"  value="{{$info->ps_route}}" placeholder="例: /permission/index" id="ps_route" name="ps_route">
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
		var id = $('input[type="hidden"]').val();
		//alert(id);
		//ajax
		$.ajax({
			url:'{{url("/permission/edit")}}' + '/' + id,
			data:shuju,
			dataType:'json',
			type:'post',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(msg){
				if(msg.code == 1){
					layer.alert('权限编辑成功',function(){
						parent.window.location.href = parent.window.location.href;
						layer_close();
					})
				}else if(msg.code == 0){
					layer.msg(msg.error);
				}
			}
		})
	})
</script>
@endsection