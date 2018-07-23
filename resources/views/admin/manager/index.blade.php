@extends('admin/common/master')
@section('title','管理员列表')
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a class="btn btn-primary-outline radius" href="javascript:;" onclick="admin_add('添加管理员','{{url("/manager/add")}}','800','350')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> </div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-hover">
			<thead>
				<tr>
					<th scope="col" colspan="10">管理员列表</th>
				</tr>
				<tr class="text-c">
					<th width="40">ID</th>
					<th>管理员</th>
					<th>所属角色</th>
					<th>IP</th>
					<th width="130">密码</th>
					<th>创建时间</th>
					<th width="200">操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data as $v)
				<tr class="text-c">
					<td>{{$v->manager_id}}</td>
					<td>{{$v->username}}</td>
					<td>{{$v->role_name}}</td>
					<td>{{$v->ip}}</td>
					@if($v->manager_id == 1)
					<td></td>
					@else
					<td><a class="btn btn-warning-outline radius" onclick="change_pwd('员工丢失密码','{{url("/manager/set")}}/{{$v->manager_id}}','430','250')">找回密码</a></td>
					@endif
					<td>{{$v->created_at}}</td>
					@if($v->manager_id == 1)
					<td></td>
					@else
					<td class="td-manage"><a class="btn btn-secondary radius" title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','{{url("/manager/edit")}}/{{$v->manager_id}}','','800','350')" class="ml-5" style="text-decoration:none">管理员编辑</a> <a class="btn btn-warning radius" title="删除" href="javascript:;" onclick="admin_del(this,'{{$v->manager_id}}')" class="ml-5" style="text-decoration:none">删除</a></td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
@section('my-js')

<script type="text/javascript">
/*管理员-密码修改*/
function change_pwd(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '{{url("/manager/del")}}/' + id,
			dataType: 'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success: function(data){
				if(data.code == 1){
					$(obj).parents("tr").remove();
					layer.msg('已删除!',{icon:1,time:1000});
				}else if(data.code == 0){
					layer.alert('删除失败,请重新删除!');
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}

/*管理员-编辑*/
function admin_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}



/*管理员-停用*/
function admin_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		
		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
		$(obj).remove();
		layer.msg('已停用!',{icon: 5,time:1000});
	});
}

/*管理员-启用*/
function admin_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		
		
		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
		$(obj).remove();
		layer.msg('已启用!', {icon: 6,time:1000});
	});
}
</script>
@endsection