<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Models\Manager;
use App\Http\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	//显示管理后台
    public function index(Request $request)
    {
    	$mg_id = \Auth::guard('back')->user()->manager_id;

    	try {
    		$ps_ids = Manager::find($mg_id)->role->ps_ids;
	    	$ps_ids = explode(',',$ps_ids);
	    	//0权限
	    	$permission_a = Permission::where('ps_level','0')
	    				  ->whereIn('ps_id',$ps_ids)
	    				  ->get();
	    	//1权限
	    	$permission_b = Permission::where('ps_level','1')
	    				  ->whereIn('ps_id',$ps_ids)
	    				  ->get();
    	} catch (\Exception $e) {
    		if($mg_id == 1){
    			//root
    			//0权限
		    	$permission_a = Permission::where('ps_level','0')->get();
		    	//1权限
		    	$permission_b = Permission::where('ps_level','1')->get();
    		}else{
    			//0权限
		    	$permission_a = [];
		    	//1权限
		    	$permission_b = [];
    		}
    	}
    	
    	return view('admin.index.index',compact('permission_a','permission_b','mg_id'));
    }
    //显示欢迎页面
    public function welcome()
    {
    	return view('admin.index.welcome');
    }
}
