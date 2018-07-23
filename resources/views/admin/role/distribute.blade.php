@extends('admin/common/master')
@section('title','权限分配')
@section('content')
<article class="page-container">
	<form  class="form form-horizontal" id="form-admin-role-add">
		<input type="hidden" name="role_id" value="{{$role->role_id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$role->role_name}}" readonly="readonly" id="role_name" name="role_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">网站角色：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<?php 
					$ps_ids_arr = explode(',',$role->ps_ids);
				?>
				@foreach($permission_a as $v)
				<dl class="permission-list">
					<dt>
						<label>
							<input type="checkbox" value="{{$v->ps_id}}" name="quanxian[]" 
							@if(in_array($v->ps_id,$ps_ids_arr))
							checked
							@endif
							>
							{{$v->ps_name}}</label>
					</dt>
					<dd>
					@foreach($permission_b as $vv)
						@if($vv->ps_pid == $v->ps_id)
							<dl class="cl permission-list2">
								<dt>
									<label class="">
										<input type="checkbox" value="{{$vv->ps_id}}" name="quanxian[]" 
										@if(in_array($vv->ps_id,$ps_ids_arr))
										checked
										@endif
										>
										{{$vv->ps_name}}</label>
								</dt>
									<dd>
								@foreach($permission_c as $vvv)
									@if($vvv->ps_pid == $vv->ps_id)
										<label class="">
											<input type="checkbox" value="{{$vvv->ps_id}}" name="quanxian[]" 
											@if(in_array($vvv->ps_id,$ps_ids_arr))
											checked
											@endif
											>
											{{$vvv->ps_name}}</label>
									@endif
								@endforeach
									</dd>
							</dl>	
						@endif
					@endforeach
					</dd>
				</dl>
				@endforeach
			</div>
		</div>
		<br/>
		<div class="row cl">
			<div class="col-xs-8 col-sm-2 col-xs-offset-4 col-sm-offset-10">
				<button type="submit" class="btn btn-success radius " id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定提交</button>
			</div>
		</div>
	</form>
</article>
@endsection
@section('my-js')
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
	$(function(){
	$(".permission-list dt input:checkbox").click(function(){
		$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
	});
	$(".permission-list2 dd input:checkbox").click(function(){
		var l =$(this).parent().parent().find("input:checked").length;
		var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
		if($(this).prop("checked")){
			$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
			$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
		}
		else{
			if(l==0){
				$(this).closest("dl").find("dt input:checkbox").prop("checked",false);
			}
			if(l2==0){
				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
			}
		}
	});
	
	//ajax
	$('#form-admin-role-add').submit(function(evt){
		evt.preventDefault();
		var shuju = $(this).serialize();
		var role_id = $("input[name='role_id']").val();
		//至少一个被选中
		if($(':checkbox:checked').length<1){
			layer.alert('请选取分配的权限');
			return false;
		}
		//ajax
		$.ajax({
			url:'{{url("/role/distribute")}}' + '/' + role_id,
			data:shuju,
			dataType:'json',
			type:'post',
			headers:{
				'X-CSRF-TOKEN':"{{csrf_token()}}"
			},
			success:function(msg){
				if(msg.code == 1){
					layer.alert('权限修改成功!',function(){
						parent.window.location.href = parent.window.location.href;
						layer_close();
					});
				}else if(msg.code == 0){
					layer.alert("角色修改权限失败!");
				}
			}
		})
	})
});
</script>
@endsection