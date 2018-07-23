<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Models\Cj;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CjController extends Controller
{
    //抽奖导入次数的查询
    public function cj_logs(Request $request,$id,$activity_type)
    {
    	error_reporting(0);
    	$cj_logs = DB::table('cj')->select('cj.id','count','mem_no','cj.activity_type','cj.created_at','activity.name','cj_sum','mem_id')
    					->leftJoin('member','cj.mem_id','member.id')
    					->leftJoin('activity','cj.activity_type','activity.id')
    					->where([
				    		['cj.mem_id',$id],
				    		['cj.activity_type',$activity_type]
    					])->paginate(5);
    	
    	return view('admin.Cj.cj_logs',compact('cj_logs'));
    }
    //增减抽奖次数
    public function zj(Request $request)
    {
    	if($request->isMethod('post')){
    		$flag = $request->input('flag');
    		$id = $request->input('mem_id');
    		$activity_type = $request->input('activity_type');
    		//dd($request->all());
    		switch ($flag) {
    			case '-':
    				DB::table('member')->where([['id',$id],['activity_type',$activity_type]])->decrement('cj_sum',1);
    				$data = DB::table('member')->where([['id',$id],['activity_type',$activity_type]])->value('cj_sum');
    				//dd($data);
    				return ['code'=>1,'data'=>$data];
    			case '+': 
    				DB::table('member')->where([['id',$id],['activity_type',$activity_type]])->increment('cj_sum',1);
    				$data = DB::table('member')->where([['id',$id],['activity_type',$activity_type]])->value('cj_sum');
    				return ['code'=>1,'data'=>$data];
    		}
    	}
    }
}
