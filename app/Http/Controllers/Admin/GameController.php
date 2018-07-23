<?php

namespace App\Http\Controllers\Admin;

use DB;
use Validator;
use App\Http\Models\Prize;
use App\Http\Models\Sudoku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
	//大转盘详情(备注可以编辑,,奖品可以选择--图片展示跟随奖品--确定可以输入)
    public function index(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $res = Sudoku::where('id',$data['id'])->update($data);
            //dd($res);
            return ['code'=>1];
        }
    	$sudoku = Sudoku::leftJoin('prize','sudoku.prize_id','prize.prize_id')->get();
        //dd($sudoku);
        $prize = Prize::select('prize_id','p_name')->get();
    	return view('admin.game.index',compact('sudoku','prize'));
    }

    //奖项录入
    public function prize_input(Request $request)
    {
    	if($request->isMethod('post')){
            //数据校验
            $data = $request->all();
            $res = $this->prize_yz($data);
            if(!$res['code']){
                return ['code'=>0,'error'=>$res['error']];
            };
            Prize::create($data);
            return ['code'=>1];
        }
    	return view('admin.game.prize_input');
    }
    //奖项编辑(没有验证)
    public function prize_edit(Request $request,$id)
    {
        if($request->isMethod('post')){
            $p_img = Prize::where('prize_id',$id)->value('p_img');
            if($p_img != $request['p_img']){    //数据库内的图片和表单提交的图片不一样
                $res = @unlink('.' . $p_img);
                
            };
            //更新数据
            Prize::where('prize_id',$id)->update(['p_name'=>$request['p_name'],'p_img'=>$request['p_img'],'p_rules'=>$request['p_rules']]);
            return ['code'=>1];
        }
        $prize = Prize::where('prize_id',$id)->first();
        return view('admin.game.prize_edit',compact('prize'));
    }
    //奖项删除
    public function prize_del(Request $request,$id)
    {
        if($request->isMethod('post')){
            //删除数据库的文件之后不删除本地的图片
            $res = Prize::where('prize_id',$id)->delete();
            return ['code'=>1];
        } 
    }
    //奖品图片的联动
    public function linkage(Request $request,$id)
    {
       if($request->isMethod('post')){
            $img_rules = Prize::where('prize_id',$id)->first();
            return ['code'=>1,'p_img'=>$img_rules['p_img']];
            dd($request->all());
       } 
    }
    //奖项录入验证
    public function prize_yz($data)
    {
        //验证不为空然后入库
            $rules = [
                'p_name'=>'required|unique:prize',
                'p_rules'=>'required',
                'p_img'=>'required'
            ];
            $notice = [
                'p_name.required'=>'奖励名称必须填写!',
                'p_name.unique'=>'奖励名称重复了!',
                'p_rules.required'=>'活动类型必须选则!',
                'p_img.required'=>'图片必须上传必须填写!',
            ];
            $validator = Validator::make($data,$rules,$notice);
            if($validator->passes()){
                return ['code'=>true];
            }
            $error = collect($validator->messages())->implode('0', '|');
            return ['code'=>false,'error'=>$error];
    }
    //奖项列表
    public function prize_index(Request $request)
    {
        $prize = Prize::paginate(11);
        $count = $prize->count();
        return view('admin.game.prize_index',compact('prize','count'));
    }
   
    //概率控制器
    public function control(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data['contr']);
            switch ($data['contr']) {
                case '+':
                    Sudoku::where('id',$data['id'])->increment('percent',10);
                    $data = Sudoku::where('id',$data['id'])->value('percent');
                    //dd($data);
                    return ['code'=>1,'data'=>$data];
                
                case '-':
                    Sudoku::where('id',$data['id'])->decrement('percent',10);
                    $data = Sudoku::where('id',$data['id'])->value('percent');
                    return ['code'=>1,'data'=>$data];
            }
            //dd($request->all());
        }
    }

    //集卡规则
    public function rules(Request $request)
    {
        if($request->isMethod('post')){
            $card_id = $request->input('card_id');
            $data = $request->only(['desc','sudoku_id']);
            $z = DB::table('card')->where('card_id',$card_id)->update($data);
            if($z){
                return ['code'=>1];
            };
            return ['code'=>0,'error'=>'操作失败,重新尝试!'];
        }
        $cards = DB::table('card')->get();
        //dd($cards);
        return view('admin.game.rules',compact('cards'));
    }

    //集卡信息添加
    public function addrules(Request $request)
    {
        if($request->isMethod('post')){
            DB::table('card')->insert($request->all());
            return ['code'=>1];
        }
        return view('admin/game/addrules');
    }
}
