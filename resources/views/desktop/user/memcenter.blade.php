@extends('desktop/common/master')
@section('title','会员中心')
@section('content')
<link rel="stylesheet" href="/desktop/css/personal-style.css">
<div id="wrap">
		<div id="header">
			<div class="header-content clearfix">
				<div class="logo fl"></div>
				<p class="fl">欢迎您：<span>{{$member->mem_no}}</span></p>
				<div class="title fr">
					<ul>
						<li><a href="/">返回首页</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="word">
			<div class="w-wrap"></div>
		</div>
		<div id="main">
			<div class="main-content">
				<div class="turntable clearfix">
					<div class="option fl">
						<p>个人中心</p>
						<ul>
							<li>
								<i class="iconfont icon-bhjaward"></i>
								<span class="focus" id="cj_logs">用户抽奖信息</span>
							</li>
							<li>
								<i class="iconfont icon-tupian"></i>
								<span id="get_cj_info">碎片获取信息</span>
							</li>
							<li>
								<i class="iconfont icon-msnui-person-info"></i>
								<span>个人信息设置</span>
							</li>
						</ul>
					</div>
					<div class="right-content1 right-content on">
						<div class="right-top">
							<i class="iconfont icon-bhjaward"></i>
							<p>用户抽奖信息</p>

						</div>
						<div class="right-main">
							<form action="">
								<table>
									<thead>
										<tr>
											<th>编号</th>
											<th>用户名</th>
											<th>抽奖时间</th>
											<th>获奖礼品</th>
											<th>状态</th>
										</tr>
									</thead>
									<tbody id="tbody">
										<!-- 获取前十个数据(内容填充去) -->
									</tbody>
								</table>
							</form>
						</div>
					</div>
					<div class="right-content2 right-content clearfix">
						<div class="right-top">
							<i class="iconfont icon-tupian"></i>
							<p >碎片获取信息</p>
						</div>
						<div class="suipian-info fl" id="jika">
							<!-- 集卡信息放置区 -->
						</div>
						<div class="exchange fr">
							<form action="">
								<p>玩法说明:1.返奖比例：当期投注额的50%，其中49%用于当期奖金分配，1%用于调节基金。2.中奖号码由6个红色球号码和1个蓝色球号码组成。根据投注号码与中奖玩法说明</p>
								<input type="button" value="兑换奖品">
							</form>
						</div>
						<div class="exchange-hidden">
							<form action="">
								<p>请您确认你的手机号码是否有误,我公司客服人员会及时联系您！</p>
								<input  type="text" class="txt" placeholder="请输入您的手机号码" value="{{$member->mem_mobile}}">
								<input  type="button" class="btn" value="确定">
							</form>
							<i></i>
						</div>
					</div>
					<div class="right-content3 right-content">
						<div class="right-top">
							<i class="iconfont icon-msnui-person-info"></i>
							<p>个人信息设置</p>
						</div>
						<div class="user-info">
							<ul>
								<li>
									<p>会员账号:
										<span>{{$member->mem_no}}</span>
									</p>
								</li>
								<li>
									<p>姓名：
										<span>{{$member->mem_name}}</span>
									</p>
								</li>
								<li>
									<p>联系方式：
										<span>{{$member->mem_mobile}}</span>
									</p>
								</li>
								<li>
									<p>剩余抽奖次数：
										<span>{{$member->cj_sum}}</span>
									</p>
								</li>
								<li>
									<a href="{{url('/user/password')}}">修改密码</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
@section('my-js')
<script type="text/javascript" src="/desktop/js/personJs.js"></script>
<script type="text/javascript">
//点击提交
$('input[class="btn"]').click(function(){
	var phone = $('input[type="text"]').val();
	//ajax
	$.ajax({
		url:'{{url("/user/tijiao")}}',
		data:{phone:phone},
		dataType:'json',
		type:'post',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(data){
			if(data != false){
				//debugger;
				
				if(data.huodong_1.code == 1){
					var user = data.huodong_1.data.user;
					var phone = data.huodong_1.data.phone;
					var msg1 = data.huodong_1.data.huodong_1;
					var msg2 = "";
					_alert();
				}else{
					layer.msg('您的卡片不足,请看一下规则进行提交!');
				}
				if(data.huodong_2.code == 1){
					var user = data.huodong_2.data.user;
					var phone = data.huodong_2.data.phone;
					var msg2 = data.huodong_2.data.huodong_2;
					var msg1 = "";
					_alert();
				}else{
					layer.msg('您的卡片不足,请看一下规则进行提交!');
				}
				if(data.huodong_1.code == 1 && data.huodong_2.code ==1){
					var msg1 = data.huodong_1.data.huodong_1;
					var msg2 = data.huodong_2.data.huodong_2;
					_alert();
				}else{
					layer.msg('您的卡片不足,请看一下规则进行提交!');
				}
				
				function _alert(){
					layer.alert('尊敬的 ' + user + ' 您的手机号吗是 ' + phone + ' 您兑换了我公司以下活动: <br/>' + msg1 + '<br>' + msg2,function(){
						parent.window.location.href = parent.window.location.href;
					});
				}
			}
		}
	})
});
//点击获取抽奖信息
$('#get_cj_info').click(function(){
	//ajax
	$.ajax({
		url:'{{url("/user/get_info")}}',
		data:'',
		dataType:'json',
		type:'post',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(data){
			var div = '';
			for (var i = 0; i < data.length; i++) {
				div += '<div><p>拥有数量：<span>'+data[i]['user_count'] + '</span></p>';
				div	+= '<img src="' +data[i]['p_img']+ '">';
				div += '<input type="hidden" name="prize_id" value="'+data[i]['prize_id']+'"></div>';
			}
			console.log(div);
			$('#jika').empty();
			$('#jika').append(div);
		}
	});
});
$(function(){
	//获取用户抽奖记录 死循环
	ajax();
	setInterval(ajax,5000);
	//发送ajax
	function ajax(){
		$.ajax({
			url:'{{url("/user/memcenter")}}',
			data:'',
			dataType:'json',
			type:'post',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(data){
				var tr = "<tr>";
				
				for (var i =0; i < data.length; i++) {
					tr += "<td>"+ data[i]['logs_id'] +"</td>";
					tr += "<td>"+ data[i]['mem_no'] +"</td>";
					tr += "<td>"+ data[i]['created_at'] +"</td>";
					tr += "<td>"+ data[i]['p_name'] +"</td>";
					if(data[i]['status'] == 1){
						tr += "<td><span style='color: #009933'><strong>已到账</strong></span></td></tr>";
					}else{
						tr += "<td><span style='color: #e60000'><strong>未处理</strong></span></td></tr>";
					}
					//console.log(td);
				}
				//console.log(tr);
				$('#tbody').empty();
				$('#tbody').append(tr);
			}
		})
	}
});
</script>
@endsection