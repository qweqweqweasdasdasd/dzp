@extends('admin/common/master')
@section('title','权限列表')
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限管理 <span class="c-gray en">&gt;</span> 权限列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="admin_permission_add('添加权限节点','{{url("/permission/add")}}','800','450')" class="btn btn-primary-outline radius"><i class="Hui-iconfont">&#xe600;</i> 添加权限节点</a></span> </div>
	<div class="mt-20">
		<table class="table table-border table-bordered radius">
			<thead>
				<tr>
					<th scope="col" colspan="9">权限节点</th>
				</tr>
				<tr class="text-c">
					<th width="50">ID</th>
					<th width="150">权限名称</th>
					<th>上级</th>
					<th>控制器</th>
					<th>操作方法</th>
					<th>路由</th>
					<th>等级</th>
					<th width="150">创建时间</th>
					<th width="180">操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data as $v)
				<tr class="text-c">
					<td>{{$v['ps_id']}}</td>
					<td style="text-align: left;">{{str_repeat('|&nbsp;&nbsp;&nbsp;',$v['ps_level']) . $v['ps_name']}}</td>
					<td>{{$v['ps_pid']}}</td>
					<td>{{$v['ps_c']}}</td>
					<td>{{$v['ps_a']}}</td>
					<td>{{$v['ps_route']}}</td>
					<td>{{$v['ps_level']}}</td>
					<td>{{$v['created_at']}}</td>
					<td><a class="btn btn-secondary radius" title="权限编辑" href="javascript:;" onclick="admin_permission_edit('权限编辑','{{url("/permission/edit")}}/{{$v["ps_id"]}}','','800','450')" class="ml-5" style="text-decoration:none">权限编辑</a> <a class="btn btn-warning radius" title="删除" href="javascript:;" onclick="admin_permission_del(this,'{{$v["ps_id"]}}')" class="ml-5" style="text-decoration:none">删除</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
/*管理员-权限-添加*/
function admin_permission_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-权限-编辑*/   
function admin_permission_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}

/*管理员-权限-删除*/
function admin_permission_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '{{url("/permission/del")}}/' + id,
			dataType: 'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success: function(data){
				if(data.code == 1){
					$(obj).parents("tr").remove();
					layer.msg('已删除!',{icon:1,time:1000});
				}else if(data.code == 0){
					layer.msg(data.error);
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