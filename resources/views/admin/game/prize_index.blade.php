@extends('admin/common/master')
@section('title','奖项管理')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/page.css">
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="#" onclick="member_add('添加奖品','{{url("/game/prize_input")}}','800','480')" class="btn btn-secondary radius">添加奖品</a></span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<div class="mt-20">
	<table class="table table-border">
		<thead>
			<tr class="text-c">
				<th>ID</th>
				<th>奖励名称</th>
				<th width="200">图片展示</th>
				<th>活动类型</th>
				<!-- <th>创建时间</th> -->
				<th>更新时间</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($prize as $v)
			<tr class="text-c">
				<td>{{$v->prize_id}}</td>
				<td>{{$v->p_name}}</td>
				<td><img src="{{$v->p_img}}" width="50"></td>
				<td>
					@if($v->p_rules == 0)
					集卡玩法
					@else
					直派彩金
					@endif
				</td>
				<!-- <td>{{$v->created_at}}</td> -->
				<td>{{$v->updated_at}}</td>
				<td class="td-manage">
					<a title="编辑" class="btn btn-default" href="javascript:;" onclick="member_edit('编辑','{{url("/game/prize_edit")}}/{{$v->prize_id}}','4','','510')" class="ml-5" style="text-decoration:none">编辑</a> 
					<a title="删除" class="btn btn-default" href="javascript:;" onclick="member_del(this,'{{$v->prize_id}}')" class="ml-5" style="text-decoration:none">删除</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>
	{{ $prize->links() }}
</div>
@endsection
@section('my-js')
<script type="text/javascript">
//添加奖品录入
function member_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*用户-编辑*/
function member_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*用户-删除*/
function member_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '{{url("/game/prize_del")}}' + '/' + id,
			dataType: 'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success: function(data){
				if(data.code == 1){
					$(obj).parents("tr").remove();
					layer.msg('已删除!',{icon:1,time:1000});
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