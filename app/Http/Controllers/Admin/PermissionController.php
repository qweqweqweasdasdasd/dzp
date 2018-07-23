<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Models\Permission;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
	//显示权限
    public function index(Request $request)
    {
    	$info = Permission::get()->toArray();
    	$data = generateTree($info);
    	return view('admin.permission.index',compact('data'));
    }

    //添加权限
    public function add(Request $request)
    {
    	if($request->isMethod('post')){
    		$data = $request->all();
    		$res = $this->ps_check($data);
    		if($res['code'] != true){
    			return ['code'=>0,'error'=>$res['error']];
    		};
    		//制作等级
    		if($data['ps_pid'] != 0){
    			$pinfo = Permission::where('ps_id',$data['ps_pid'])->first();
    			$data['ps_level'] = (string)($pinfo['ps_level'] + 1);
    		}else {
    			$data['ps_level'] = '0';
    		}
    		//创建数据
    		$res = Permission::create($data);
    		if($res){
    			return ['code'=>1];
    		};
    		return ['code'=>0,'error'=>'添加失败,请重新操作'];
    	}
    	$info = Permission::whereIn('ps_level',['0','1'])->get()->toArray();
    	$data = generateTree($info);
    	return view('admin.permission.add',compact('data'));
    }

    //编辑权限
    public function edit(Request $request,$id)
    {
    	if($request->isMethod('post')){
    		$data = $request->all();
    		$res = $this->ps_check($data);
    		if($res['code'] != true){
    			return ['code'=>0,'error'=>$res['error']];
    		};
    		//制作等级
    		if($data['ps_pid'] != 0){
    			$pinfo = Permission::where('ps_id',$data['ps_pid'])->first();
    			$data['ps_level'] = (string)($pinfo['ps_level'] + 1);
    		}else {
    			$data['ps_level'] = '0';
    		}
    		//更新数据
    		$res = Permission::where('ps_id',$id)->update($data);
    		if($res){
    			return ['code'=>1];
    		};
    		return ['code'=>0,'error'=>'添加失败,请重新操作'];
    	}
    	$info = Permission::where('ps_id',$id)->first();
    	$data = generateTree(Permission::whereIn('ps_level',['0','1'])->get()->toArray());
    	return view('admin.permission.edit',compact('data','info'));
    }

    //删除权限
    public function del(Request $request,$id)
    {
    	if($request->isMethod('post')){
    		//删除之前需要判断当前的权限下面有没有子权限
    		$z = Permission::where('ps_pid',$id)->first();
    		if($z != null){
    			return ['code'=>0,'error'=>'请删除子权限,才能删除该权限!'];
    		};
    		Permission::where('ps_id',$id)->delete();
    		return ['code'=>1,'error'=>'权限删除成功!'];
    	}
    }
    //权限验证码规则
    public function ps_check($data=array())
    {
    	$rules = [
    		'ps_name'=>'required|max:100',
    		'ps_pid'=>'required',
    		'ps_c'=>'required|max:50',
    		'ps_a'=>'required|max:50',
    		'ps_route'=>'required',
    	];
    	$notices = [
    		'ps_name.required'=>'权限名称必须存在!',
    		'ps_pid.required'=>'父权限ID必须存在!',
    		'ps_c.required'=>'控制器必须存在!',
    		'ps_a.required'=>'操作方法必须存在!',
    		'ps_route.required'=>'路由必须存在!',
    		'ps_name.max'=>'权限名称不得超出100个字符!',
    		'ps_c.max'=>'控制器不得超出50个字符!',
    		'ps_a.max'=>'操作方法不得超出50个字符!',
    	];
    	$validator = Validator::make($data,$rules,$notices);
    	if($validator->passes()){
    		return ['code'=>true];
    	}
    	$error = collect($validator->messages())->implode('0','|');
    	return ['code'=>false,'error'=>$error];
    }
}
