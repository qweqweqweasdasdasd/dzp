@extends('admin/common/master')
@section('title','添加规则')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">描述(活动内容): </label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" placeholder="描述" id="desc" name="desc">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">卡片id(以点为分界符): </label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text"  placeholder="卡片id" id="sudoku_id" name="sudoku_id">
		</div>
	</div>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
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
			url:'{{url("/game/addrules")}}',
			data:shuju,
			dataType:'json',
			type:'post',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(data){
				if(data.code == 1){
					layer.alert('添加ok了',function(){
						parent.window.location.href = "{{url('/game/rules')}}";
						layer_close();
					})
				}
			}
		});
	});
</script>
@endsection