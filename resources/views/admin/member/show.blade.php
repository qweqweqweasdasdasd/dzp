@extends('admin/common/master')
@section('title','兑换显示列表')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/page.css">
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 会员管理 <span class="c-gray en">&gt;</span> 会员派彩 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
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
					<th>奖品</th>
					<th>活动类型</th>
					<th>状态</th>
					<th width="300">生成时间</th>
					<th width="230">操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($prize_logs as $v)
				<tr class="text-c">
					<td>{{$v->logs_id}}</td>
					<td>{{$v->mem_no}}</td>
					<td>{{$v->p_name}}</td>
					<td>
						@if($v->p_rules == 1)
						<span style="color: #e60000;font-size: 14px;"><strong>直派彩金</strong></span>
						@elseif($v->p_rules == 0)
						<span style="color: #009933;font-size: 14px;"><strong>集卡活动</strong></span>
						@endif
					</td>
					<td>
						@if($v->status ==0)
						<a href="#" id="not" class="btn btn-danger-outline radius">未处理</a>
						@else
						<a href="#" class="btn btn-success-outline radius">已处理</a>
						@endif
					</td>
					<td>{{$v->created_at}}</td>
					<td class="f-14 td-manage"> 
						<a style="text-decoration:none" class="btn btn-secondary radius" onClick="article_del(this,'{{$v->logs_id}}')" href="javascript:;" title="编辑">彩金添加完毕</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	{{ $prize_logs->appends(['keyword'=>$keyword])->links() }}
</div>
@endsection
@section('my-js')
<script type="text/javascript">
	function article_del(obj,id){
		$.ajax({
				url: '{{url("/exchange/sended")}}' + '/' + id,
				type: 'POST',
				dataType: 'json',
				headers:{
					'X-CSRF-TOKEN':"{{csrf_token()}}"
				},
				success: function(data){
					if(data.code == 1){
						layer.msg('处理',function(msg){
							window.location.href = window.location.href;
							/*$("#not").attr('class','btn btn-success-outline radius');
							$("#not").text('已处理');*/
						})
					}else if(data.code == 0){
						layer.msg('已处理了');
					}
				},
				error:function(data) {
					console.log(data.msg);
				},
			});
	}
	$(function(){
		//实时查询
		setInterval(function(){
			//window.location.href = '{{url("/exchange/show")}}';
			$.ajax({
				url:'{{url("/exchange/newdata")}}',
				data:'',
				type:'post',
				dataType:'json',
				headers:{
					'X-CSRF-TOKEN':"{{csrf_token()}}"
				},
				success:function(msg){
					if(msg.code == 1){
						layer.msg('有新的彩金需要处理的呢',{offset:"250px"},function(){
							window.location.href = window.location.href;
						});
					}
				}
			})
		},8000);
	})
</script>
@endsection
