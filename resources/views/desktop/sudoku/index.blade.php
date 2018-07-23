@extends('desktop/common/master')
@section('title','九宫格抽奖')
@section('content')
<!-- 外部大盒子 -->
	<div id="wrap">
		<!-- 固定整体背景 -->
		<div class="bg-wrap"></div>
		<!-- 隐藏大背景不允许操作 -->
		<div class="control"></div>
		<!-- 头部区域 -->
		@include('desktop/sudoku/header')
		<div class="word">
			<div class="w-wrap"></div>
		</div>
		<!-- 主体区域 -->
		<div id="main">
			<div class="main-content">
				<div class="turntable">
					<div class="turntable-top">
						<div class="info clearfix">
							@if(session()->exists('username'))
							<p class="fl">用户名:<span>{{session('username')}}</span></p>
							<p class="fr">可抽奖次数:<span>{{$member->cj_sum}}</span></p>
							@else
							<p class="fl">用户名:<span>未登录</span></p>
							<p class="fr">可抽奖次数:<span>不可见</span></p>
							@endif
						</div>
						<!-- <div class="turn turn-wrap">抽奖区</div> -->
						<!-- <div class="palace turn-wrap">转盘抽奖区</div> -->
					</div>
					<div class="table-main clearfix">
						<!-- <div class="palace-main">
							<div class="table fl">转盘区</div>
							<div class="record fr">中奖记录</div>
						</div> -->
						<div class="turn-main clearfix">
							<!-- 宫格抽奖区 -->
							<div class="table fl">
								<!-- 抽奖区 -->
								<div class="draw" id="lottery">
									<table>
										<tr>
											<td class="item lottery-unit lottery-unit-0">
												<div class="img">
													<img src="{{$sudoku[0]['p_img']}}" alt="">
												</div>
												<span class="name" id="item_0">{{$sudoku[0]['keyword']}}</span>
											</td>
											<td class="gap"></td>
											<td class="item lottery-unit lottery-unit-1">
												<div class="img">
													<img src="{{$sudoku[1]['p_img']}}" alt="">
												</div>
												<span class="name" id="item_1">{{$sudoku[1]['keyword']}}</span>
											</td>
											<td class="gap"></td>
											<td class="item lottery-unit lottery-unit-2">
												<div class="img">
													<img src="{{$sudoku[2]['p_img']}}" alt="">
												</div>
												<span class="name" id="item_2">{{$sudoku[2]['keyword']}}</span>
											</td>
										</tr>
										<tr>
											<td class="gap-2" colspan="5"></td>
										</tr>
										<tr>
											<td class="item lottery-unit lottery-unit-7">
												<div class="img">
													<img src="{{$sudoku[7]['p_img']}}" alt="">
												</div>
												<span class="name" id="item_7">{{$sudoku[7]['keyword']}}</span>
											</td>
											<td class="gap"></td>
											<td class=""><a class="draw-btn" href="javascript:">立即抽奖</a></td>
											<td class="gap"></td>
											<td class="item lottery-unit lottery-unit-3">
												<div class="img">
													<img src="{{$sudoku[3]['p_img']}}" alt="">
												</div>
												<span class="name" id="item_3">{{$sudoku[3]['keyword']}}</span>
											</td>
										</tr>
										<tr>
											<td class="gap-2" colspan="5"></td>
										</tr>
										<tr>
											<td class="item lottery-unit lottery-unit-6">
												<div class="img">
													<img src="{{$sudoku[6]['p_img']}}" alt="">
												</div>
												<span class="name" id="item_6">{{$sudoku[6]['keyword']}}</span>
											</td>
											<td class="gap"></td>
											<td class="item lottery-unit lottery-unit-5">
												<div class="img">
													<img src="{{$sudoku[5]['p_img']}}" alt="">
												</div>
												<span class="name" id="item_5">{{$sudoku[5]['keyword']}}</span>
											</td>
											<td class="gap"></td>
											<td class="item lottery-unit lottery-unit-4">
												<div class="img">
													<img src="{{$sudoku[4]['p_img']}}" alt="">
												</div>
												<span class="name" id="item_4">{{$sudoku[4]['keyword']}}</span>
											</td>
										</tr>
									</table>
								</div>
							</div>
							<!-- 获奖信息区域 -->
							@include('desktop/sudoku/info')
						</div>
					</div>
					<!-- 游戏规则区域 -->
					@include('desktop/sudoku/rules')
				</div>
			</div>
		</div>
		<div id="footer"></div>
	</div>
	<!-- 隐藏登录界面 -->
@include('desktop/sudoku/login')
@endsection
@include('desktop/common/js')
@section('my-js')
<script type="text/javascript">
	//登录
	$('#form').submit(function(evt){
		//alert('ok');
		evt.preventDefault();
		var shuju = $(this).serialize();
		//ajax
		$.ajax({
			url:'{{url("/user/login")}}',
			data:shuju,
			type:'post',
			dataType:'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(msg){
				if(msg.code == 1){
					$('#login').attr('class','login-hidden');
					$('#wrap').attr('style','opacity: 1;');	//有延迟
					layer.alert('欢迎来到全民玩抽奖!',{offset:'400px'},function(){
						location.replace(location); 
					});
				}else if(msg.code == 0){
					alert(msg.error);
				}
			}
		});
		//console.log(shuju);
	});
	//退出
	function logout(){
		layer.confirm('您要退出么?',{offset:'400px'},function(){
					//ajax
			$.ajax({
				url:'{{url("/user/logout")}}',
				data:'',
				dataType:'json',
				type:'post',
				headers:{
					'X-CSRF-TOKEN':'{{csrf_token()}}'
				},
				success:function(msg){
					if(msg.code == 1){
						location.replace(location);
					}
				}
			});
		});

	}
</script>
@endsection

