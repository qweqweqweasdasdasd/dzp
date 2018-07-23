@extends('admin/common/master')
@section('title','import')
@section('content')
<link rel="stylesheet" href="/admin/static/build/layui.css" media="all">
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/page.css">
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 会员管理 <span class="c-gray en">&gt;</span> 会员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-10">
		<div class="skin-minimal">
			@foreach($activity as $v)
			<div class="radio-box">
			   <input type="radio" id="radio-1" name="demo-radio1" checked value="{{$v->id}}">
			   <label for="radio-1">{{$v->name}}</label>
			</div>
			@endforeach
			<button type="button" class="layui-btn" id="import">
			  <i class="layui-icon">&#xe67c;</i> 导入CSV数据
			</button>&nbsp;&nbsp;&nbsp;&nbsp;
			<span><strong>导入数据格式</strong>: 会员账号,姓名,密码,电话,抽奖次数</span>
			<span class="r">共有数据：<strong id="count">{{$count}}</strong> 条</span> 
		</div>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20">
		<div class="text-l">
		 <span class="select-box inline">
		 	<form id="search">
				<select name="activity_type" id="select" class="select" style="width: 200px;height: 25px;">
					@foreach($activity as $v)
					<option value="{{$v->id}}">{{$v->name}}</option>
					@endforeach
				</select>
				</span> 
				<!-- <input type="text" name="keyword" id="" placeholder=" 输入批次号或者会员账号" style="width:250px" class="input-text"> -->
				&nbsp;&nbsp;&nbsp;
				<button name="" id="" class="btn btn-success radius" type="submit">批次查询</button>
				&nbsp;&nbsp;<span style="color: red">数据回滚只是减掉抽奖的次数</span>
			</form>
		</div>
	</div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover">
		<thead>
			<tr class="text-c">
				<th width="60">ID</th>
				<!-- <th>会员名称</th>
				<th>用户名</th> -->
				<!-- <th width="40">性别</th> -->
				<!-- <th>密码</th>
				<th>手机</th> -->
				<!-- <th>抽奖次数</th> -->
				<th>导入批次</th>
				<th>活动类型</th>
				<th width="180">导入时间</th>
				<th>操作者</th>
				<th width="150">操作</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
	</div>
	<div id="links">
	
	</div>
</div>

@endsection
@section('my-js')
<script src="/admin/static/build/layui.all.js"></script>
<script type="text/javascript">
layui.use('upload', function(){
  var upload = layui.upload;
  //执行实例
  var uploadInst = upload.render({
    elem: '#import' //绑定元素
    ,url: '/member/import' //上传接口
    ,accept:'file'	//允许上传的文件类型
    ,headers:{
    	'X-CSRF-TOKEN':'{{csrf_token()}}'
    }
    ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
    	var data = {};
	   	data.radio = $("input[name='demo-radio1']:checked").val();
	   	this.data = data;
	}
    ,done: function(res){
      if(res.code == 1){
      	layer.alert('导入数据成功!',function(){
      		window.location.reload() = window.location.reload();
      	});
      }else if(res.code == 0){
      	alert(res.error);
      }
    }
    ,error: function(){
      //请求异常回调
    }
  });
});	
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	})});

//查询
$('#search').submit(function(evt){
	evt.preventDefault();
	var shuju = $(this).serialize();
	//ajax
	$.ajax({
		url:'{{url("/member/search")}}',
		data:shuju,
		type:'post',
		dataType:'json',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(msg){
			//追加数据
			if(msg.code == 1){
				$("tbody").empty();			//删除文件
				$('tbody').append(msg.datas);	//追加数据
				$("#links").empty();		
				$('#links').append(msg.pages);	//第一次查询的时候需要显示分页
				$("#count").empty();
				$("#count").append(msg.count);
			}
		}
	});
});

//简单分页
function getData(page){
	var keyword = $('input[name="keyword"]').val();
	var select = $('#select option:selected').val();

	console.log(page);
	//ajax
	$.ajax({
		url:'{{url("/member/search")}}',
		data:{keyword:keyword,activity_type:select,page:page},
		type:'post',
		dataType:'json',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(msg){
			//追加数据
			if(msg.code == 1){
				$("tbody").empty();			//删除文件
				$('tbody').append(msg.datas);	//追加数据
				$("#links").empty();		
				$('#links').append(msg.pages);	//第二次的时候更新分页
			}
		}
	});
	//alert(page);
}
/*数据回滚-删除*/
function member_del(obj,order){

	layer.confirm('确认要回滚数据吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '{{url("/member/rollback")}}' +'/'+ order,
			dataType: 'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}
</script>
@endsection

