@extends('admin/common/master')
@section('content')
<div class="page-container">
<form class="form form-horizontal" id="form-admin-add">
	<input type="hidden" name="id" value="{{$id}}">
	<div class="row cl">
		<!-- <label class="form-label col-xs-4 col-sm-3">备注：</label> -->
		<div class="formControls col-xs-12 col-sm-12">
			<textarea name="desc" id="desc" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="$.Huitextarealength(this,100)">{{$info->desc}}</textarea>
			<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
		</div>
	</div>
	<div class="row cl">
		<div class="col-xs-3 col-sm-9 col-xs-offset-9 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
	$('#form-admin-add').submit(function(evt){
		evt.preventDefault();
		//var shuju = $(this).serialize();
		var desc = $('#desc').val();
		var id = $('input[name="id"]').val();
		//ajax
		$.ajax({
			url:'{{url("/jika/jikaset")}}' + '/' + id,
			data:{desc:desc},
			type:'post',
			dataType:'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(data){
				if(data.code == 1){
					layer.alert('修改成功了!',function(){
						parent.window.location.href = parent.window.location.href;
						layer_close();
					})
				}
			}
		});
		console.log(shuju);
	})
</script>
@endsection