<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Models\Role;
use App\Http\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Models\Permission;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
	//角色列表
    public function index(Request $request)
    {
    	$roles = Role::orderBy('role_id','asc')->get();
    	return view('admin.role.index',compact('roles'));
    }

    //权限分配
    public function distribute(Request $request,Role $role)
    {
    	if($request->isMethod('post')){
    		$ps_ids = implode(',', $request->input('quanxian'));	//array -> string
    		//拼接" 控制器 " - " 方法 "
    		$ps_ca = Permission::whereIn('ps_id',$request->input('quanxian'))
    						->select(\DB::raw("concat(ps_c,'-',ps_a) as ca"))
    						->whereIn("ps_level",[1,2])
    						->pluck('ca');
    		//把array变成string
    		$str = implode(',', $ps_ca->toArray());

    		$res = $role->update([
    			'ps_ids'=>$ps_ids,
    			'ps_ca'=>$str,
    			'updated_at'=>date('Y-m-d H:i:s',time())
    		]);
    		return ['code'=>1];
    	}
    	$permission_a = Permission::where('ps_level','0')->get();
    	$permission_b = Permission::where('ps_level','1')->get();
    	$permission_c = Permission::where('ps_level','2')->get();
    	return view('admin.role.distribute',compact('role','permission_a','permission_b','permission_c'));
    }

    //删除角色
    public function del(Request $request,$id)
    {
    	if($request->isMethod('post')){
    		$z = Role::where('role_id',$id)->delete();
    		return $z == 1 ? ['code'=>1]: ['code'=>0,'error'=>'角色删除失败!'];
    	}
    }
}
