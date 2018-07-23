<?php

namespace App\Http\Controllers\Desktop;

use DB;
use App\Http\Models\Sudoku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SudokuController extends Controller
{
    //显示抽奖页面
   	public function index()
   	{
   		$mem_no = session('username');
   		$member = DB::table('member')->where([['mem_no',$mem_no],['activity_type',2]])->first();	//会员和活动类型
   		//dd($member);
   		$sudoku = Sudoku::leftJoin('prize','sudoku.prize_id','prize.prize_id')->get()->toArray();
   		return view('desktop.sudoku.index',compact('sudoku','member'));
   	}
}
