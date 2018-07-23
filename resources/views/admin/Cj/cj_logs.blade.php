@extends('admin/common/master')
@section('title','导入次数记录')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/page.css">
<div class="page-container">
	 <span class="r">抽奖次数：&nbsp;<a href="#" id="plus" class="btn btn-default"><i class="Hui-iconfont">&#xe600;</i></a>&nbsp;&nbsp;<strong>{{$cj_logs[0]->cj_sum}}</strong>&nbsp;&nbsp;<a id="minus" class="btn btn-default" href="#"><i class="Hui-iconfont">&#xe6a1;</i></a></span>
	 <br>
<div class="mt-30">
		<table class="table table-border table-bg">
			<tdead>
				<input type="hidden" name="mem_id" value="{{$cj_logs[0]->mem_id}}">
				<input type="hidden" name="activity_type" value="{{$cj_logs[0]->activity_type}}">
				<tr class="text-c">
					<td>id</td>
					<td>会员账号</td>
					<td>抽奖次数</td>
					<td>活动所属</td>
					<td>操作时间</td>
				</tr>
			</tdead>
			<tbody>
				@foreach($cj_logs as $v)
				<tr class="text-c">
					<td>{{$v->id}}</td>
					<td>{{$v->mem_no}}</td>
					<td>{{$v->count}}</td>
					<td>{{$v->name}}</td>
					<td>{{$v->created_at}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
{{ $cj_logs->links() }}
	<div class="row cl">
		<div class=" col-sm-2 col-sm-offset-10">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;修改保存&nbsp;&nbsp;">
		</div>
	</div>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
//点击保存
$('input[type="submit"]').click(function(){
	layer.alert('保存成功',function(){
		parent.window.location.href = "{{url('/member/index')}}";
		layer_close();
	});
});
//点击加一
$('#plus').click(function(){
	var mem_id = $('input[name="mem_id"]').val();
	var activity_type = $('input[name="activity_type"]').val();
	$.ajax({
		url:'{{url("/member/zj")}}',
		data:{mem_id:mem_id,activity_type:activity_type,flag:'+'},
		dataType:'json',
		type:'post',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(msg){
			if(msg.code == 1){
				$('strong').html(msg.data);
				//location.reload() = location.reload();
			}
		}
	});
	/*console.log(mem_id);
	console.log(activity_type);*/
	//alert('+');
})
//点击减一
$('#minus').click(function(){
	var mem_id = $('input[name="mem_id"]').val();
	var activity_type = $('input[name="activity_type"]').val();
	//ajax 
	$.ajax({
		url:'{{url("/member/zj")}}',
		data:{mem_id:mem_id,activity_type:activity_type,flag:'-'},
		dataType:'json',
		type:'post',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(msg){
			if(msg.code == 1){
				$('strong').html(msg.data);
				//location.reload() = location.reload();
				//alert('ok');
			}
		}
	});
	console.log(mem_id);
	console.log(activity_type);
})
</script>
@endsection