@extends('admin/common/master')
@section('title','规则设置')
@section('content')
<div class="page-container">
	<div class="mt-20">
		<div class="panel panel-default">
			<div class="panel-header">集卡设置</div>
			<div class="panel-body">
				<div class="mt-10">
					<!-- <a href="#" onclick="add('添加规则','{{url("/game/addrules")}}','600','300')" class="pull-right btn btn-primary-outline radius">添加</a> -->
					<br/><br/>
				<table class="table table-border">
					<thead>
						<tr class="text-c">
							<th width="80" id="id">集卡规则ID</th>
							<th width="700">描述(活动内容)<span style="color: red;"> 点击可以编辑</span></th>
							<th>卡片id(以点为分界符)<span style="color: red;"> 点击可以编辑</span></th>
							<th width="100">操作</th>
						</tr>
					</thead>
					<tbody>
						@foreach($cards as $v)
						<tr class="text-c">
							<td>{{$v->card_id}}</td>
							<td>{{$v->desc}}</td>
							<td>{{$v->sudoku_id}}</td>
							<td class="td-manage"><a style="text-decoration:none" class="btn btn-success-outline radius" onClick="picture_del(this,'10001')" href="javascript:;" title="修改保存">修改保存</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>	
			</div>
		</div>
	</div>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
//集卡规则的添加
function add(title,url,w,h){
	layer_show(title,url,w,h);
}
//实时编辑
$(function(){
	//alert('ok');
	var tds = $('tr').find('td:lt(3):gt(0)');
	tds.click(function(){
		var td = $(this);
		var oldtext = $(this).text();
		var id = td.parent().find('td:eq(0)').text();
		var input = $('<input class="input-text radius" value="'+ oldtext +'">');
		td.html(input);
		input.click(function(){
			return false;
		})
		input.width(td.width);

		input.blur(function(){
			var input_blur = $(this);
			var newtext = input_blur.val();
			td.html(newtext);
			//ajax
		})
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
                    //ajax
                break;  
                  
                case 27://按下esc键，取消修改，把文本框变成文本  
                    td.html('<font color="#00b33c" size="2">'+ oldtext +'</font>');   
                break;  
            }  
		});	
		//console.log(newtext);
		//console.log(id);
		
	});
});
/*修改-保存*/
function picture_del(obj,id){
	var card_id = $(obj).parent().parent().find('td:eq(0)').text();
	var desc = $(obj).parent().parent().find('td:eq(1)').text();
	var sudoku_id = $(obj).parent().parent().find('td:eq(2)').text();
	$.ajax({
			type: 'POST',
			url: '{{url("/game/rules")}}',
			dataType: 'json',
			data:{card_id:card_id,desc:desc,sudoku_id:sudoku_id},
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success: function(data){
				if(data.code == 1){
					layer.msg('修改成功!');
				}else if(data.code == 0){
					layer.msg('你没有进行修改的呢!');
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
	});		
	console.log(card_id);
	console.log(desc);
	console.log(sudoku_id);
};
</script>
@endsection