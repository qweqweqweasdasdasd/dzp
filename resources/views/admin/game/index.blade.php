@extends('admin/common/master')
@section('title','活动显示')
@section('content')
<div class="page-container">
	<div class="mt-20">
		<div class="panel panel-default">
			<div class="panel-header">大转盘详情 : &nbsp;&nbsp;&nbsp;
				<span style="color: #cc0000;"> 中奖几率可以无限大但是不可以为负数 ( 0 为中不到奖 ) </span>
			</div>
			<div class="panel-body">
				<table class="table table-border">
					<thead>
						<tr class="text-c">
							<th width="80">ID</th>
							<th width="100">位置</th>
							<th width="500">九宫格文字备注(可编辑)</th>
							<th width="200">奖品</th>
							<th >图片</th>
							<th width="150">中奖几率</th>
							<th width="300">操作</th>
						</tr>
					</thead>
					<tbody>
						@foreach($sudoku as $v)
						<tr class="text-c">
							<td>{{$v->id}}</td>
							<td>{{$v->place}}</td>
							<td>{{$v->keyword}}</td>
							<td>
							<span class="select-box">
								<select class="select" size="1" name="demo1" onchange="linkage(this)">
									<option value="">请选择奖品</option>	
									@foreach($prize as $vv)
								 	<option value="{{$vv->prize_id}}" 
								 		@if($v->prize_id == $vv->prize_id)
								 		selected
								 		@endif
								 	>{{$vv->p_name}}</option>
									@endforeach
								</select>
							</span>
							</td>
							<td><img src="{{$v->p_img}}" width="50"></td>
							<td><a href="#"  class="btn btn-default" onclick="control(this,'+','{{$v->id}}')"><i class="Hui-iconfont">&#xe600;</i></a>
								<span id="percent">{{$v->percent}}</span>
								<a href="#"  class="btn btn-default" onclick="control(this,'-','{{$v->id}}')"><i class="Hui-iconfont">&#xe6a1;</i></a></td>
							<!-- 添加input记录是什么玩法 -->
							<td><a href="#" class="btn btn-success-outline radius" onclick="_save(this)">修改保存</a></td>	
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
//概率的增加和减少
function control(obj,contr,id){
	//ajax
	$.ajax({
		url:'{{url("/game/control")}}',
		data:{id:id,contr:contr},
		dataType:'json',
		type:'post',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(msg){
			if(msg.code == 1){
				//ok 的时候进行处理的逻辑
				var item = $(obj).parent().find('#percent').text(msg.data);
				console.log(item);
			}
		}
	})
	//alert(contr);
}
//实时编辑九宫格文件备注
$(function(){
	var tds = $('tr').find('td:eq(2)');
	tds.click(function(){
		var td = $(this);
		var oldtext = td.text();
		//创建文本框
		var input = $('<input class="input-text radius" type="text" value="'+oldtext+'">');
		td.html(input);
		//文本框点击事件取消
		input.click(function(){
			return false;
		});
		input.width(td.width);
		//当文本失去焦点时变为文本
		input.blur(function(){
			var input_blur = $(this);
			var newtext = input_blur.val();
			td.html(newtext);
			console.log(newtext);
		});
		//响应键盘事件  
        input.keyup(function(event){  
            // 获取键值  
            var keyEvent=event || window.event;  
            var key=keyEvent.keyCode;  
            //获得当前对象  
            var input_blur=$(this);  
            switch(key)  
            {  
                case 13://按下回车键，保存当前文本框的内容  
                    var newText=input_blur.val();   
                    td.html(newText);   
                break;  
                  
                case 27://按下esc键，取消修改，把文本框变成文本  
                    td.html(oldText);   
                break;  
            }  
        });  
		//alert('ok');
	})
})
//保存
function _save(obj){
	//var item = $(obj).parent().parent();	//tr
	var id = $(obj).parent().prev().prev().prev().prev().prev().prev().text();		//id
	var keyword = $(obj).parent().prev().prev().prev().prev().text();		//keyword
	var prize_id = $(obj).parent().prev().prev().prev().find('option:selected').val();	//prize_id
	//ajax
	$.ajax({
		url:'{{url("/game/index")}}',
		data:{id:id,keyword:keyword,prize_id:prize_id},
		type:'post',
		dataType:'json',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(msg){
			if(msg.code == 1){
				layer.msg('该行数据已经更新!');
			}
		}
	})
	console.log(id);
	console.log(keyword);
	console.log(prize_id);
}
//改变下拉触发的事件
function linkage(obj){
	//var id = $(obj).parent().parent().prev().prev().prev().text();
	var prize_id = $(obj).find('option:selected').val();
	//ajax
	$.ajax({
		url:'{{url("/game/linkage")}}'+'/'+prize_id,
		data:'',
		type:'post',
		dataType:'json',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(msg){
			if(msg.code == 1){
				$(obj).parent().parent().next().find('img').attr('src',msg.p_img);
			}
		}
	})
	console.log(prize_id);
}
</script>
@endsection