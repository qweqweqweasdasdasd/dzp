@extends('admin/common/master')
@section('title','角色列表')
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限管理 <span class="c-gray en">&gt;</span> 角色列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<!-- <div class="cl pd-5 bg-1 bk-gray"> <span class="l">  <a class="btn btn-primary-outline radius size-M" href="javascript:;" onclick="admin_role_add('添加角色','admin-role-add.html','800')"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a> </span> </div> -->
	<div class="mt-20">
		<table class="table table-border table-bordered table-hover">
			<thead>
				<tr>
					<th scope="col" colspan="7">角色管理</th>
				</tr>
				<tr class="text-c">
					<th width="50px;">ID</th>
					<th>角色名</th>
					<th>对应的ids</th>
					<th>权限CA</th>
					<th>创建时间</th>
					<th width="200px;">操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($roles as $v)
				<tr class="text-c">
					<td>{{$v->role_id}}</td>
					<td>{{$v->role_name}}</td>
					<td>{{$v->ps_ids}}</td>
					<td>{{$v->ps_ca}}</td>
					<td>{{$v->updated_at}}</td>
					<td class="f-14"><a class="btn btn-success radius" title="分配权限" href="javascript:;" onclick="admin_role_edit('分配权限',
					'{{url("/role/distribute")}}/{{$v->role_id}}','1','820','700')" style="text-decoration:none">分配权限</a> <a class="btn btn-warning radius" title="删除" href="javascript:;" onclick="admin_role_del(this,'{{$v->role_id}}')" style="text-decoration:none">删除</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
/*管理员-角色-添加*/
function admin_role_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-角色-编辑*/
function admin_role_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*管理员-角色-删除*/
function admin_role_del(obj,id){
	layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '{{url("/role/del")}}' + '/' + id,
			dataType: 'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success: function(data){
				if(data.code == 1){
					$(obj).parents("tr").remove();
					layer.msg('已删除!',{icon:1,time:1000});
				}else if(data.code == 0){
					layer.msg('角色删除失败!');
				}
				
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}
</script>
@endsection