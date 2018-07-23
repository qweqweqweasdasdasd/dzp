@extends('admin/common/master')
@section('title','添加奖品')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/static/build/layui.css">
<div class="page-container">
	<div class="mt-20">
		<form class="form form-horizontal" id="form-article-add">
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-3">奖励品名称：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" placeholder="输入奖品名称" name="p_name" style="width: 200px;">
				</div>
			</div>
			<div class="row cl" >
				<label class="form-label col-xs-4 col-sm-3">活动类型：</label>
				<div class="formControls col-xs-8 col-sm-9" style="width: 300px;">
					<span class="select-box">
					<select name="p_rules" class="select" >
						<option value="0">集卡玩法</option>
						<option value="1">直派彩金</option>
					</select>
					</span>
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3">图片预览：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<img src="/images/sudoku-20180714214852-19708.jpg" alt="no img" style="width: 100px;height: 100px;">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3">url地址：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input class="input-text" type="text" name="p_img" readonly="readonly">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3">物品图片：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<button type="button" class="layui-btn" id="test1">
					  <i class="layui-icon">&#xe67c;</i>上传图片
					</button>&nbsp;&nbsp;<span style="color: #ff3300">图片尺寸不得大于100*100</span>
				</div>
			</div>
			<br/>
			<div class="line"></div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3"> </label>
				<div class="formControls col-xs-8 col-sm-9">
					<button type="submit" class="btn btn-secondary radius">确认保存</button>
				</div>
			</div>
		</form>	
	</div>
</div>
@endsection
@section('my-js')
<script type="text/javascript" src="/admin/static/build/layui.all.js"></script>
<script type="text/javascript">
	//提交保存
	$('#form-article-add').submit(function(evt){
		evt.preventDefault();
		var shuju = $(this).serialize();
		//ajax
		$.ajax({
			url:'{{url("/game/prize_input")}}',
			type:'post',
			data:shuju,
			dataType:'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(msg){
				if(msg.code == 1){
					layer.alert('添加奖品成功!',function(){
						parent.window.location.href = "{{url('/game/prize_index')}}";
						layer_close();
					})
				}else if(msg.code == 0){
					alert(msg.error);
				}
			}
		});
	});
	layui.use('upload', function(){
	  var upload = layui.upload;
	   
	  //执行实例
	  var uploadInst = upload.render({
	    elem: '#test1' //绑定元素
	    ,url: '/upload' //上传接口
	    ,accept: 'images'	//上传图片
	    ,headers:{
	    	'X-CSRF-TOKEN':'{{csrf_token()}}'
	    }
	    ,done: function(res){
	      //上传完毕回调
	      if(res.code == 1){
	      	$('input[name="p_img"]').val(res.url_path);
	      	$('img').attr('src',res.url_path);
	      }else if(res.code == 0){
	      	layer.alert(res.error);
	      }
	    }
	    ,error: function(){
	      //请求异常回调
	    }
	  });
	});
</script>
@endsection