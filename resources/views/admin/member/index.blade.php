@extends('admin/common/master')
@section('title','会员列表')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/page.css">
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 会员管理 <span class="c-gray en">&gt;</span> 会员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="{{url('/member/index')}}" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20">
		<div class="text-l">
		 <span class="select-box inline">
		 	<form id="search">
				<select name="activity_type" id="select" class="select" style="width: 200px;height: 25px;">
					@foreach($activity as $v)
					<option value="{{$v->id}}"
					@if($input['activity_type'] == $v->id)
					selected
					@endif
					>{{$v->name}}</option>
					@endforeach
				</select>
				</span> 
				<input type="text" name="keyword" value="{{$input['keyword']}}" placeholder=" 会员账号" style="width:250px" class="input-text">
				<button name="" id="" class="btn btn-success radius" type="submit">会员查询</button>
				&nbsp;&nbsp;<font color="#f00">注: 抽奖次数修改之后需要刷新一下</font>
			</form>
		</div>
	</div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover">
		<thead>
			<tr class="text-c">	
				<th width="80">ID</th>
				<th>会员账号</th>
				<th width="180">手机(可编)</th>
				<th>姓名(可编)</th>
				<th width="480">密码(密文)</th>
				<th>抽奖次数(可查)</th>
				<th>活动类型</th>
				<th width="150">创建时间</th>
				<th width="200">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $v)
			<tr class="text-c">
				<td>{{$v->id}}</td>
				<td>{{$v->mem_no}}</td>
				<td><font color="#00b33c" size="2">{{$v->mem_mobile}}</font></td>
				<td><font color="#00b33c" size="2">{{$v->mem_name}}</font></td>
				<td>{{$v->mem_pwd}}</td>
				<td><a href="#" style="text-decoration:none" onclick="cj_sum('导入次数记录','{{url("/member/cj_logs")}}/{{$v->id}}/{{$v->activity_type}}','800','500')"><font color="#00b333" size="2">{{$v->cj_sum}}</font></a></td>
				<td>{{$v->name}}</td>
				<td>{{$v->created_at}}</td>
				<td class="td-manage">
					<!-- <a title="编辑" class="btn btn-secondary " href="javascript:;" onclick="member_edit('编辑','member-add.html','4','','510')" class="ml-5" style="text-decoration:none">编辑</a>  -->
					<a class="btn btn-success " style="text-decoration:none" class="ml-5" onClick="change_password('会员修改密码','{{url("/member/reset_pwd")}}/{{$v->id}}','450','250')" href="javascript:;" title="会员修改密码">修改密码</a> 
					<a title="删除" class="btn btn-warning " href="javascript:;" onclick="member_del(this,'{{$v->id}}')" class="ml-5" style="text-decoration:none">删除</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>
	{{ $data->appends(['activity_type'=>@$input['activity_type'],'keyword'=>@$input['keyword']])->links() }}
</div>
@endsection
@section('my-js')
<script type="text/javascript">
$(function(){
	var tds = $('tr').find('td:lt(4):gt(1)');
	//给所有的td添加事件
	tds.click(function(){
		var td = $(this);
		var oldtext = td.text();
		var id = td.prev().prev().text();

		var input = $('<input class="input-text radius" value="'+ oldtext +'">');
		td.html(input);
		input.click(function(){	//失去焦点
			return false;
		})
		input.width(td.width);
		/*input.blur(function(){
			var input_blur = $(this);
			var newtext = input_blur.val();
			td.html(newtext);
			//ajax
			console.log(newtext);
		});*/
		input.keyup(function(event){
			// 获取键值  
            var keyEvent=event || window.event;  
            var key=keyEvent.keyCode;  
            //获得当前对象  
            var input_blur=$(this);  
            switch(key)  
            {  
                case 13://按下回车键，保存当前文本框的内容  
                    var newtext=input_blur.val();   
                    td.html(newtext);
                    if(isNaN(newtext)){	//是数字
                    	var id = td.prev().prev().prev().text();
                    }
                    console.log(newtext);
                    //ajax
                    $.ajax({
                    	url:'{{url("/member/real_edit")}}',
                    	data:{id:id,newtext:newtext},
                    	type:'post',
                    	dataType:'json',
                    	headers:{
                    		'X-CSRF-TOKEN':'{{csrf_token()}}'
                    	},
                    	success:function(msg){
                    		if(msg.code == 1){
                    			layer.alert('信息修改成功',function(){
                    				window.location.href = window.location.href;
                    			});
                    		}
                    	}
                    });
                break;  
                  
                case 27://按下esc键，取消修改，把文本框变成文本  
                    td.html('<font color="#00b33c" size="2">'+ oldtext +'</font>');   
                break;  
            }  
		});	
	})
})
//会员修改密码
function change_password(title,url,w,h){
	layer_show(title,url,w,h);
}
//抽奖次数的历史查询
function cj_sum(title,url,w,h){
	layer_show(title,url,w,h);
}
//会员删除
function member_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '{{url("/member/del")}}' + '/' + id,
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