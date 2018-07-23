<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Models\Sudoku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RulesController extends Controller
{
    //九宫格展示
    public function sudoku(Request $request)
    {
        if($request->isMethod('post')){
            $mem_no = $request->input('username');
            //判断用户是否有足够的抽奖次数
            $res = $this->is_permisson($mem_no);
            //dd($res);
            if(!$res['code']){
                return ['errorcode'=>1,'error'=>$res['error']];
            }
            //奖品的id关键字  奖品的内容  下标不要动
            //初始化奖品池，8个奖品，满概率100，最小概率为1(id,name以实际数据库取出的数据为准，percent之和等于100)
            $array = Sudoku::select('id','keyword','percent')->get()->toArray();
            //下标存储数组100个下表，0-7 按概率分配对应的数量
            $indexarr = array();
            for($i=0;$i<count($array);$i++){
            	for($j=0;$j<$array[$i]['percent'];$j++){
            		array_push($indexarr, $i);	
            	}
            }
            //数组乱序
            shuffle($indexarr);
            //从下标数组中随机取一个下标作为中奖下标，$rand_index 是$indexArr的随机元素的下标（0-99）
            $rand_index = array_rand($indexarr,1);
            //中奖信息
            $prize_index = $indexarr[$rand_index];
            $prize_info  = $array[$prize_index]['keyword'];
            $sudoku_id = $array[$prize_index]['id'];
            $prize_id = Sudoku::where('id',$sudoku_id)->value('prize_id');
            //dd($prize_id);
            $created_at = date('Y-m-d H:i:s',time());
            //抽奖记录 ===> 谁抽奖 , 抽奖是什么 , 是什么活动 , 什么时间 , 状态(到账,未到账) ==>抽奖之后删除抽奖的资格 
            $z = DB::table('prize_logs')->Insert(['mem_no'=>$mem_no,'prize_id'=>$prize_id,'status'=>'0','created_at'=>$created_at]);  
            //dd($array[$prize_index]);
            if($z){
                DB::table('member')->where([['mem_no',$mem_no],['activity_type',2]])->decrement('cj_sum');  //大转盘活动
            }
            return ['errorcode'=>0,'rewardid'=>$prize_info];
        }
        $sudoku = Sudoku::leftJoin('prize','sudoku.prize_id','prize.prize_id')->get()->toArray();
        //dd($sudoku);
    	return view('admin.rules.sudoku',compact('sudoku'));
    }

    //抽奖是否有权限(次数是否ok)
    public function is_permisson($mem_name)
    {
        //判断抽奖的次数是否为0或者负值
        $cj_sum = DB::table('member')->where('mem_no',$mem_name)->value('cj_sum');
        if($cj_sum <= 0){
            return ['code'=>false,'error'=>'您的抽奖次数已经使用完了呢!'];
        };
        return ['code'=>true];
    }

}
