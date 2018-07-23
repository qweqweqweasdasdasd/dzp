@extends('admin/common/master')
@section('title','集卡列表')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/page.css">
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 会员管理 <span class="c-gray en">&gt;</span> 会员集卡 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> 
		<form id="search">
			<input type="text" name="keyword" value="{{$keyword}}" placeholder=" 会员账号" style="width:250px" class="input-text">
			&nbsp;&nbsp;
			<button name="" id="" class="btn btn-success radius" type="submit">会员查询</button>
			&nbsp;&nbsp;
			<span class="r">共有数据：<strong>{{$count}}</strong> 条</span>
		</form>
	</div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-hover">
			<thead>
				<tr class="text-c">
					<th width="80">ID</th>
					<th>会员账号</th>
					<th>手机号码</th>
					<th>活动</th>
					<th width="400">备注</th>
					<th width="200">生成时间</th>
					<th width="170">操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data as $v)
				<tr class="text-c">
					<td>{{$v->jika_id}}</td>
					<td>{{$v->user}}</td>
					<td>{{$v->phone}}</td>
					<td>{{$v->huodong_desc}}</td>
					<td><span style="color: #5EB95E;font-size: 14px;"><strong>{{$v->desc}}</strong></span></td>
					<td>{{$v->created_at}}</td>
					<td class="f-14 td-manage"> 
						<a style="text-decoration:none" class="btn btn-secondary radius" onClick="admin_edit('集卡备注','{{url("/jika/jikaset")}}/{{$v->jika_id}}','','500','260')" href="javascript:;" title="修改备注">修改备注</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	{{ $data->appends(['keyword'=>$keyword])->links() }}
</div>
@endsection
@section('my-js')
<script type="text/javascript">
function admin_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
//定时刷新
$(function(){
	setInterval(function(){
		$.ajax({
			url:'{{url("/jika/jika_new_data")}}',
			data:'',
			dataType:'json',
			type:'post',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(data){
				if(data.code == 1){
					layer.msg(data.msg,function(){
						window.location.href = "{{url('/jika/list')}}";
					});
				}
			}
		});
	},8000);
})
</script>
@endsection
