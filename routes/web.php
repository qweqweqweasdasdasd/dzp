<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
////////////////////////////////////////////////前端页面//////////////////////////////////////////////////////////

//抽奖页面的显示
Route::get('/', 'Desktop\SudokuController@index');
//前端用户登录
Route::post('/user/login','User\UserController@login');

Route::group(['middleware'=>'UseCheck'],function(){
	//九宫格显示
	Route::match(['get','post'],'/sudoku/index','Admin\RulesController@sudoku');
	//进入个人中心
	Route::match(['get','post'],'/user/memcenter','User\UserController@memcenter');
	//会员的密码修改
	Route::match(['get','post'],'/user/password','User\UserController@password');
	//前端用户退出
	Route::post('/user/logout','User\UserController@logout')->name('logout');
	//获取用户集卡信息
	Route::post('/user/get_info','User\UserController@get_cj_info');
	//提交用户集卡兑换
	Route::post('/user/tijiao','User\UserController@tijiao');

});

//管理后台登录
Route::match(['get','post'],'login','Admin\LoginController@index')->name('login');
//退出登录
Route::get('/logout','Admin\LoginController@logout');
//安全的中间件
Route::group(['middleware'=>'Anquan'],function(){
	//显示welcome
	Route::get('/admin/welcome','Admin\IndexController@welcome');
	//显示后台管理
	Route::get('/admin/index','Admin\IndexController@index');  

	//翻墙中间件
	Route::group(['middleware'=>'Fanqiang'],function(){
		////////////////////////////////////////////权限管理///////////////////////////////////////////////////
		//角色列表
		Route::get('/role/index','Admin\RoleController@index');
		//权限分配
		Route::match(['get','post'],'/role/distribute/{role}','Admin\RoleController@distribute');
		//角色删除
		Route::post('/role/del/{role}','Admin\RoleController@del');

		//权限列表
		Route::get('/permission/index','Admin\PermissionController@index');
		//添加权限
		Route::match(['get','post'],'/permission/add','Admin\PermissionController@add');
		//编辑权限
		Route::match(['get','post'],'/permission/edit/{permission}','Admin\PermissionController@edit');
		//删除权限
		Route::match(['get','post'],'/permission/del/{permission}','Admin\PermissionController@del');

		//管理员列表
		Route::match(['get','post'],'/manager/index','Admin\ManagerController@index');
		//添加管理员
		Route::match(['get','post'],'/manager/add','Admin\ManagerController@add');
		//编辑管理员
		Route::match(['get','post'],'/manager/edit/{manager}','Admin\ManagerController@edit');
		//删除管理员
		Route::match(['get','post'],'/manager/del/{manager}','Admin\ManagerController@del');
		//员工密码丢失
		Route::match(['get','post'],'/manager/set/{manager}','Admin\ManagerController@set');
		//修改密码
		Route::match(['get','post'],'/manager/change_pwd','Admin\ManagerController@change_pwd');
		////////////////////////////////////////////////会员管理//////////////////////////////////////////////////////
		//会员导入
		Route::match(['get','post'],'/member/import','Admin\MemberController@import');
		//数据回滚  为负数是转换为0
		Route::post('/member/rollback/{order}','Admin\MemberController@rollback'); 
		//活动类型/批号查询
		Route::match(['get','post'],'/member/search','Admin\MemberController@search');
		//会员列表
		Route::match(['get','post'],'/member/index','Admin\MemberController@index');
		//实时编辑手机号
		Route::post('/member/real_edit','Admin\MemberController@real_edit');
		//会员修改密码
		Route::match(['get','post'],'/member/reset_pwd/{member}','Admin\MemberController@reset_pwd');
		//会员删除
		Route::post('/member/del/{member}','Admin\MemberController@del');
		//会员兑换
		Route::match(['get','post'],'/exchange/show','Admin\MemberController@show');
		//会员集卡
		Route::match(['get','post'],'/jika/list','Admin\MemberController@make');
		//会员备注修改
		Route::match(['get','post'],'/jika/jikaset/{jika}','Admin\MemberController@jikaset');
		//轮询最新的集卡数据
		Route::post('/jika/jika_new_data','Admin\MemberController@jika_new_data');
		//轮询最新抽奖记录
		Route::match(['get','post'],'/exchange/newdata','Admin\MemberController@newdata');
		//派送完毕彩金
		Route::post('/exchange/sended/{nu}','Admin\MemberController@sended');

		//导入抽奖次数记录
		Route::match(['get','post'],'/member/cj_logs/{member}/{activity_type}','Admin\CjController@cj_logs');
		//增减抽奖次数
		Route::post('/member/zj','Admin\CjController@zj');


		//////////////////////////////////////////////////活动管理///////////////////////////////////////////////////////
		//活动显示
		Route::match(['get','post'],'/game/index/{item?}','Admin\GameController@index');
		//概率控制器
		Route::post('/game/control','Admin\GameController@control');
		//奖品图片的联动
		Route::post('/game/linkage/{prize_id}','Admin\GameController@linkage');

		//集卡规则
		Route::match(['get','post'],'/game/rules','Admin\GameController@rules');
		//集卡信息添加
		Route::match(['get','post'],'/game/addrules','Admin\GameController@addrules');

		//图片上传
		Route::post('/upload','Admin\UploadController@upload');
		

		//奖项管理
		Route::get('/game/prize_index','Admin\GameController@prize_index');
		//奖项录入
		Route::match(['get','post'],'/game/prize_input','Admin\GameController@prize_input');
		//奖项编辑
		Route::match(['get','post'],'/game/prize_edit/{prize}','Admin\GameController@prize_edit');
		//奖项删除
		Route::post('/game/prize_del/{prize}','Admin\GameController@prize_del');

	});
});


