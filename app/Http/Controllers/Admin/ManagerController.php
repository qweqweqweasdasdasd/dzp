<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Validator;
use App\Http\Models\Role;
use App\Http\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagerController extends Controller
{
	//显示管理员列表
    public function index(Request $request)
    {
    	$data = Manager::select('manager_id','username','manager.created_at','role_name','ip')
				    	->leftJoin('role','manager.role_id','role.role_id')
				    	->get();
    	return view('admin.manager.index',compact('data'));
    }

    //添加管理员
    public function add(Request $request)
    {
    	if($request->isMethod('post')){
    		$data = $request->all();
    		$res = $this->mg_check($data);
    		if($res['code'] != true){
    			return ['code'=>0,'error'=>$res['error']];
    		};
    		$data['password'] = Hash::make($request->input('password'));
    		$z = Manager::create($data);
    		return ['code'=>1];
    	}
    	$role = Role::pluck('role_name','role_id');
    	return view('admin.manager.add',compact('role'));
    }

    //编辑管理员
    public function edit(Request $request,$id)
    {	
    	if($request->isMethod('post')){
    		$data = $request->all();
    		$res = $this->mg_check($data,'');
    		if($res['code'] != true){
    			return ['code'=>0,'error'=>$res['error']];
    		};
    		//dd($data);
    		$z = Manager::where('manager_id',$id)->update(['role_id'=>$data['role_id'],'username'=>$data['username'],'password'=>$data['password']]);
    		return ['code'=>1];
    	}
    	$role = Role::pluck('role_name','role_id');
    	$info = Manager::where('manager_id',$id)->first();
    	return view('admin.manager.edit',compact('role','info')); 
    }

    //删除管理员
    public function del(Request $request,$id)
    {
    	$z = Manager::where('manager_id',$id)->delete();
   		return ['code'=>1];
    }

    //员工密码丢失
    public function set(Request $request,$id)
    {
    	if($request->isMethod('post')){
    		$root_pwd = $request->input('root_pwd');
    		$hashed = Manager::where('manager_id',1)->first();
    		$reset_pwd = $request->input('reset_pwd');
    		if(Hash::check($root_pwd,$hashed->password)){
    			//验证OK
    			$new_pwd = Hash::make($reset_pwd);
    			$z = Manager::where('manager_id',$id)->update(['password'=>$new_pwd]);
    			return ['code'=>1];
    		}
    		return ['code'=>0,'error'=>'root 密码不对请重新输入!'];
    	}
    	$info = Manager::where('manager_id',$id)->first();
    	return view('admin.manager.set',compact("info"));
    }

    //修改密码
    public function change_pwd(Request $request)
    {
        if($request->isMethod('post')){
            $mg_id = $request->input('manager_id');
            $hashed = Manager::find($mg_id);
            if(Hash::check($request->input('old_pwd'),$hashed->password)){
                //旧密码核实ok
                $new_pwd = Hash::make($request->input('new_pwd'));
                Manager::where('manager_id',$mg_id)->update(['password'=>$new_pwd]);
                return ['code'=>1];
            };
            return ['code'=>0,'error'=>'旧密码不对请重新输入!'];
        }
        $info = Manager::find(\Auth::guard('back')->user()->manager_id);
        return view('admin.manager.change_pwd',compact('info'));
    }

    //表单数据验证
    public function mg_check($data=array(),$unique="unique:manager")
    {
    	$rules = [
    		'role_id'=>'required',
    		'username'=>"required|max:10|{$unique}",
    		'password'=>'required|max:255'
    	];
    	$notices = [
    		"role_id.required"=>'角色必须存在!',
    		"username.required"=>'管理员必须填写!',
    		"username.unique"=>'该管理员已经存在!',
    		'username.max'=>'管理员不得超出10个字符!',
    		'password.required'=>'密码必须存在!',
    		'password.max'=>'密码不得超出了255个字符'
    	];
    	$validator = Validator::make($data,$rules,$notices);
    	if($validator->passes()){
    		return ['code'=>true];
    	}
    	$error = collect($validator->messages())->implode('0', '|');
    	return ['code'=>false,'error'=>$error];
    }
}
