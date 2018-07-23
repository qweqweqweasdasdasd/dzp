<div id="header">
			<div class="header-content clearfix">
				<div class="logo fl"></div>
				@if(session()->exists('username'))
				<p class="fl">欢迎您：<span id="username">{{session('username')}}</span></p>
				@endif
				<div class="title fr">
					<ul>
						@if(session()->exists('username'))
						<li class="loginout" onclick="logout()">注销</li>
						@else
						<li class="login on">登录</li>
						@endif
						<li><a href="{{url('/user/memcenter')}}">个人中心</a></li>
					</ul>
				</div>
			</div>
		</div>