<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
	//显示登录页面
    public function index(Request $request)
    {
    	if($request->isMethod('post')){
    		$datas = $request->all();
    		$res = $this->login_check('username','password','code',$datas);
    		//登录合理验证
    		if($res['code'] != true){
    			return ['code'=>0,'error'=>$res['error']];
    		};
    		//登录合法验证(auth)
    		$pwd_user = $request->only(['username','password']);
    		$res = \Auth::guard('back')->attempt($pwd_user);
    		if($res != true){
    			return ['code'=>0,'error'=>'用户名和密码不对'];
    		};
    		return ['code'=>1];
    	}
    	return view('admin.login.index');
    }
    
    //退出登录
    public function logout(Request $request)
    {
        \Auth::guard('back')->logout();
        return redirect('/login');
    }

    //登录验证
    public function login_check($username,$password,$code,$datas)
    {
    	$rules = [
    		"username"=>'required|max:12',
    		"password"=>'required|max:12',
    		"code"=>'required|captcha'
    	];
    	$notices = [
    		"username.required"=>'用户必须存在!',
    		"username.max"=>'用户字符不得超出12个!',
    		"password.required"=>'密码必须存在!',
    		"password.max"=>'密码字符不得超出12个!',
    		"code.required"=>'验证码必须存在!',
    		"code.captcha"=>'验证码错误!',
    	];
    	$validator = Validator::make($datas,$rules,$notices);
    	if($validator->passes()){
    		return ['code'=>true];
    	}
    	$error = collect($validator->messages())->implode('0', '|');
    	return ['code'=>false,'error'=>$error];
    }
}
