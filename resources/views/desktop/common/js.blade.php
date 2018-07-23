<script type="text/javascript">
	var lottery = {
	index: -1,    //当前转动到哪个位置，起点位置
	count: 0,     //总共有多少个位置
	timer: 0,     //setTimeout的ID，用clearTimeout清除
	speed: 20,    //初始转动速度
	times: 0,     //转动次数
	cycle: 50,    //转动基本次数：即至少需要转动多少次再进入抽奖环节
	prize: -1,    //中奖位置
	content: '',
	init: function(id) {
		if ($('#' + id).find('.lottery-unit').length > 0) {
			$lottery = $('#' + id);
			$units = $lottery.find('.lottery-unit');
			this.obj = $lottery;
			this.count = $units.length;
			$lottery.find('.lottery-unit.lottery-unit-' + this.index).addClass('active');
		};
	},
	roll: function() {
		var index = this.index;
		var count = this.count;
		var lottery = this.obj;
		$(lottery).find('.lottery-unit.lottery-unit-' + index).removeClass('active');
		index += 1;
		if (index > count - 1) {
			index = 0;
		};
		$(lottery).find('.lottery-unit.lottery-unit-' + index).addClass('active');
		this.index = index;
		return false;
	},
	stop: function(index) {
		this.prize = index;
		return false;
	}
};

function roll() {
	lottery.times += 1;
	lottery.roll(); //转动过程调用的是lottery的roll方法，这里是第一次调用初始化
	
	if (lottery.times > lottery.cycle + 10 && lottery.prize == lottery.index) {
		clearTimeout(lottery.timer);
		lottery.prize = -1;
		lottery.times = 0;
		click = false;
		setTimeout("layer.alert(lottery.content,{offset:'400px'},function(){location.replace(location);})",1000);	//提示信息
	} else {
		if (lottery.times < lottery.cycle) {
			lottery.speed -= 10;
		} else if (lottery.times == lottery.cycle) {
			//var index = Math.random() * (lottery.count) | 0; //静态演示，随机产生一个奖品序号，实际需请求接口产生
			lottery.prize = lottery.prize;		
		} else {
			if (lottery.times > lottery.cycle + 10 && ((lottery.prize == 0 && lottery.index == 7) || lottery.prize == lottery.index + 1)) {
				lottery.speed += 110;
			} else {
				lottery.speed += 20;
			}
		}
		if (lottery.speed < 40) {
			lottery.speed = 40;
		};
		lottery.timer = setTimeout(roll, lottery.speed); //循环调用
	}
	return false;
}

var click = false;

window.onload = function(){
	lottery.init('lottery');
	$('.draw-btn').click(function() {
		var username = $('#username').text();
		if(!username){
			layer.alert('请您先进行的登录!',{offset:'400px'});
			return false;
		}
		/*console.log(username);
		debugger;*/
		//已登录用户才能去抽奖
		if (click) { //click控制一次抽奖过程中不能重复点击抽奖按钮，后面的点击不响应
			return false;
		} else {	//向后端接口发请求返回中奖结果
			//请求接口返回中奖的结果
			$.ajax({
				url:'{{url("/sudoku/index")}}',
				data:{username:username},
				type:'post',
				dataType:'json',
				async:false,
				headers:{
					'X-CSRF-TOKEN':'{{csrf_token()}}'
				},
				success:function(data){
					if(data.errorcode == 0){
						var rewardid=data["rewardid"];		//奖品id
						var cardno=data["rewardCardNo"];		//奖励卡片没有
						var passno=data["rewardCardPass"];	//奖励卡片传递
						var prize=-1;	//中奖位置
						var content="";	//内容
						var item_0 =  $('#item_0').text();
						var item_1 =  $('#item_1').text();
						var item_2 =  $('#item_2').text();
						var item_3 =  $('#item_3').text();
						var item_4 =  $('#item_4').text();
						var item_5 =  $('#item_5').text();
						var item_6 =  $('#item_6').text();
						var item_7 =  $('#item_7').text();
						console.log(item_0);
						//alert();
						//debugger;
						if(rewardid == item_0)
						{
							//alert('ok');
							lottery.prize=0;
              				prize=0;
              				lottery.content="恭喜您抽到了" + item_0;
              				//alert('一部iphone6手机');
						}else if(rewardid==item_1)
						{
							lottery.prize=1;
              				prize=1;
               				lottery.content="恭喜您抽到了" + item_1;
               				//alert('一部PPTV KING7s 3D影音手机');
						}else if(rewardid==item_2)
						{
							lottery.prize=2;
				            prize=2;
				            lottery.content="恭喜您抽到了" + item_2;
				            //alert('一份乐高的玩具');
						}else if(rewardid==item_3)
						{
							lottery.prize=3;
				            prize=3;
				            lottery.content="恭喜您抽到了" + item_3;
				            //alert('一份logo的玩具');
						}else if(rewardid==item_4)
						{
							lottery.prize=4;
				            prize=4;
				            lottery.content="恭喜您抽到了" + item_4;
				            //alert('一份logo的玩具');
						}else if(rewardid==item_5)
						{
							lottery.prize=5;
				            prize=5;
				            lottery.content="恭喜您抽到了" + item_5;
				            //alert('一份logo的玩具');
						}
						else if(rewardid==item_6)
						{
							lottery.prize=6;
				            prize=6;
				            lottery.content="恭喜您抽到了" + item_6;
				            //alert('一份logo的玩具');
						}
						else if(rewardid==item_7)
						{
							lottery.prize=7;
				            prize=7;
				            lottery.content="恭喜您抽到了" + item_7;
				            //alert('一份logo的玩具');
						}
						lottery.speed = 100;
						roll(); //转圈过程不响应click事件，会将click置为false
						click = true; //一次抽奖完成后，设置click为true，可继续抽奖
						return false;
					}else{/*错误处理*/
						if(data.errorcode == 1){
							alert(data.error);
						}
					}
				}
			});
		}
	});
};
</script>