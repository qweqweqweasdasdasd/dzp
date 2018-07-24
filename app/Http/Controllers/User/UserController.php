<?php

namespace App\Http\Controllers\User;

use DB;
use Hash;
use Validator;
use App\Http\Models\Jika;
use Illuminate\Http\Request;
use App\Http\Models\Prize_logs;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //用户的登录
    public function login(Request $request)
    {
    	if($request->isMethod('post')){
    		$data = $request->all();
    		$flag = $this->use_yz($data);
    		if(!$flag['code']){ //false
    			return ['code'=>0,'error'=>$flag['error']];
    		};
    		//auth
    		$auth = $this->auth($data);
    		if($auth['code'] == false){
    			return ['code'=>0,'error'=>$auth['error']];
    		};
    		return ['code'=>1];
    	}
    }

    //用户退出
    public function logout(Request $request)
    {
        if($request->isMethod('post')){
            //$request->all();
            session()->forget('username');
            return ['code'=>1];
        }
    }

    //用户登录的验证
    public function use_yz($data)
    {
    	$rules = [
    		'mem_no'=>'required|max:16',	//会员账号|unique:mem_no
    		'mem_pwd'=>'required|max:16'	//会员密码
    	];
    	$notice = [
    		'mem_no.required'=>'亲,您的会员账号或者密码没有填写哦!',
    		'mem_no.max'=>'亲,您的会员账号不得超出16个字符!',
    		'mem_pwd.required'=>'亲,您的会员账号或者密码没有填写哦!',
    		'mem_pwd.max'=>'亲,您的密码不得超出16个字符!',
    	];
    	$validator = Validator::make($data,$rules,$notice);
    	if($validator->passes()){
    		return ['code'=>true];
    	}
    	$error = collect($validator->messages())->implode('0', '|');
    	return ['code'=>false,'error'=>$error];
    }

    //auth 
    public function auth($data)
    {
    	//验证用户是否存在,不存在返回信息
    	$mem_no = $data['mem_no'];
    	$mem_pwd = $data['mem_pwd'];
    	$info = DB::table('member')->where('mem_no',$mem_no)->first();
    	if($info == null){
    		return ['code'=>false,'error'=>'该会员不存在!'];
    	}
    	//用户存在之后判断用户的密码是否一致,不一致返回信息 
    	if(!Hash::check($mem_pwd,$info->mem_pwd)){
    		return ['code'=>false,'error'=>'密码不一致的呢!'];
    	};
    	//存到session(那里)
    	session(['username'=>$mem_no]);
        $session_id = session()->getId();
        $this->single_user($session_id,$mem_no);
        //dd($session_id);
    	//session()->flush();
    	return ['code'=>true];
    }
    //禁止单用户重复登录
    public function single_user($session_id,$mem_no)
    {
        $session = DB::table('member')->where('mem_no',$mem_no)->value('session_id');
        //dd($session_id);
        if($session === null){
            $z = DB::table('member')->where('mem_no',$mem_no)->update(['session_id'=>$session_id]);
            //dd($z);
        };
        if($session != $session_id){
            DB::table('member')->where('mem_no',$mem_no)->update(['session_id'=>$session_id]);
        }
    }
    //会员中心
    public function memcenter(Request $request)
    {
        $mem_no = session('username');
        //获取钱十个中奖数据
        if($request->isMethod('post')){
            $datas = DB::table('prize_logs')
                        ->leftJoin('prize','prize_logs.prize_id','prize.prize_id')
                        ->where([['mem_no',$mem_no],['p_rules','1']])
                        ->orderBy('logs_id','desc')
                        ->limit(10)
                        ->get();
            return $datas;
        }
     
        $member = DB::table('member')->where([['mem_no',$mem_no],['activity_type',2]])->first();    //会员和活动类型
        return view('desktop.user.memcenter',compact('member'));
    }

    //密码修改
    public function password(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            session()->forget('username');
            //dd();
            //用户修改密码验证
            if($data['newpwd'] != $data['newpwdcheck']){
                return ['code'=>0,'error'=>'新密码与确认密码不一致的哦!'];
            }
            $res = $this->user_reset_pwd($data);
            if(!$res['code']){
                return ['code'=>0,'error'=>$res['error']];
            };
            $mem_no = session('username');
            $info = DB::table('member')->where('mem_no',$mem_no)->first();
            if(!Hash::check($data['oldpwd'],$info->mem_pwd)){
                return ['code'=>0,'error'=>'您的密码输入的不正确!'];
            }  
            session()->forget('username');
            /*dd();*/
            $password = Hash::make($data['newpwd']);
            $z = DB::table('member')->where('mem_no',$mem_no)->update(['mem_pwd'=>$password]);
            
            return ['code'=>1];

        }
        $mem_no = session('username');
        $member = DB::table('member')->where([['mem_no',$mem_no],['activity_type',2]])->first();    //会员和活动类型
        //dd($member);
        return view('desktop.user.password',compact('member'));
    }

    //弹窗
    public function alert()
    {
        return "ok";
    }

    //用户修改密码验证
    public function user_reset_pwd($data)
    {
        $rules = [
            'oldpwd'=>'required|max:17',
            'newpwd'=>'required|max:17',
            'newpwdcheck'=>'required'
        ];
        $notice = [
            'oldpwd.required'=>'旧密码不得为空!',
            'oldpwd.max'=>'旧密码不得超出17个字符!',
            'newpwd.required'=>'新密码不得为空!',
            'newpwd.max'=>'新密码不得超出17个字符',
            'newpwdcheck.required'=>'确认密码不得为空',
        ];
        $validator = Validator::make($data,$rules,$notice);
        if($validator->passes()){
            return ['code'=>true];
        }
        $error = collect($validator->messages())->implode('0', ',');
        return ['code'=>false,'error'=>$error];
    }

    //获取用户的信息
    public function get_cj_info(Request $request)
    {
        if($request->isMethod('post')){
           //显示集卡信息
           $user = session('username');
           $data = Prize_logs::select(DB::raw('count(*) as user_count,p_img,p_name,dzp_prize_logs.prize_id'))
                    ->leftJoin('prize','prize_logs.prize_id','prize.prize_id')
                    ->where([['mem_no',$user],['p_rules',0]])
                    ->groupBy('p_name')
                    ->get(); 
            //dd($data);
            return $data;
        }
       /* return '0';*/
    }

    //用户提交集卡
    public function tijiao(Request $request)
    {
        //当前用户
        $user = session('username');
        $phone = $request->input('phone');
        $dataAll = [];
        $data_arr = [];
        if($request->isMethod('post')){
            $info = DB::table('member')->where('mem_no',$user)->first();
            //手机号码不一致修改
            if($info->mem_mobile != $phone){
                DB::table('member')->where('mem_no',$user)->update(['mem_mobile'=>$phone]);
            }
            //检查是否符合集卡的规则 
            $allcard = $this->allcard($user);
            //dd($allcard);
            //集卡规则== 奖品id 是否为规则内的 奖品id  符合1 .符合 2 . 符合1,2
            $card_arr = DB::table('card')->select('card_id','sudoku_id','desc')->get()->toArray();
            $card_arr_0 = explode(',', $card_arr[0]->sudoku_id);    
            $card_arr_1 = explode(',', $card_arr[1]->sudoku_id);    
            //dd($card_arr_1);
            //活动一
            $huodong_1 = $this->huodong_1($card_arr_0,$allcard,$user,$phone,$card_arr);

            if($huodong_1['code'] == 1){
                $data_arr = $huodong_1['data']['data_1'];
            };
            if($huodong_1['code'] == 0){
                $data_arr = $allcard;
            }
            //活动二
            $huodong_2 = $this->huodong_2($card_arr_1,$card_arr,$data_arr,$dataAll,$user,$phone);
            if($huodong_1['code']==1){
                //保存入库
                $user = $huodong_1['data']['user'];
                $phone = $huodong_1['data']['phone'];
                $huodong_desc_1 = $huodong_1['data']['huodong_1'];
                //dd($user);
                Jika::create(['user'=>$user,'phone'=>$phone,'huodong_desc'=>$huodong_desc_1]);
            };
            if($huodong_2['code']==1){
                //保存入库
                $user = $huodong_2['data']['user'];
                $phone = $huodong_2['data']['phone'];
                $huodong_desc_2 = $huodong_2['data']['huodong_2'];
                Jika::create(['user'=>$user,'phone'=>$phone,'huodong_desc'=>$huodong_desc_2]);
            };
            //dd($huodong_2);
            return ['huodong_1'=>$huodong_1,'huodong_2'=>$huodong_2];
        }
    }

    //活动二
    public function huodong_2($card_arr_1,$card_arr,$data_arr,$dataAll,$user,$phone)
    {
            for($i=0; $i< count($card_arr_1); $i++){    //设置的卡片id_arr 
                $prize_id_1[] = DB::table('sudoku')->where('id',$card_arr_1[$i])->value('prize_id');      
            }

            //判断设置的卡片id是否在抽奖集卡内
            $flag = true;
            $data_keys = array_keys($data_arr);
            //dd($data_keys);
            $temp_arr = array();
            for($i=0; $i< count($card_arr_1); $i++){
                if(!in_array($prize_id_1[$i], $data_keys)){
                    $flag = false;
                    return ['code'=>0];
                }
                $temp_arr[$prize_id_1[$i]] = $data_arr[$prize_id_1[$i]];
            }
            $min = min($temp_arr);
            //dd($min);
            foreach($temp_arr as $k=>$v){
                $data_arr[$k] = ($v-$min); //活动二
            }
                //两个活动都扣除了最后的数据是

            $dataAll['huodong_2'] = $card_arr[1]->desc . "数量是: " . $min;
            $dataAll['data_2'] = $data_arr;
            $dataAll['user'] = $user;
            $dataAll['phone'] = $phone;
            //dd($dataAll);
            //删除抽奖记录里面的数据
            $has_del_data = array_keys($temp_arr);
            //循环删除
            //dd($temp_arr);
            for($i = 0; $i < count($has_del_data);$i++){
                Prize_logs::where([['mem_no',$user],['prize_id',$has_del_data[$i]]])->limit($min)->delete();    
            }
            //疯狂删除数据
            if($min){
                return ['code'=>1,'data'=>$dataAll];
            }
            return ['code'=>0];
            //        == 提交之后减去数量,(1获取需要减去的数量在彩金logs 内) 记录保存到另一张表上 后台添加一个实时读取的栏目
    }

    //活动一
    public function huodong_1($card_arr_0,$allcard,$user,$phone,$card_arr)
    {
        for($i=0; $i< count($card_arr_0); $i++){    //设置的卡片id_arr 
                $prize_id[] = DB::table('sudoku')->where('id',$card_arr_0[$i])->value('prize_id');      
            }
            //如果设置卡片的IDS之和 等于 抽奖的集卡id之和则符合活动一
            //dd(array_sum(array_keys($allcard)));
            if(count($prize_id) != count(array_keys($allcard))){
                return ['code'=>0,'不符合活动一'];
            }
            if(array_sum($prize_id) == array_sum(array_keys($allcard))){
                $min = min($allcard);
                foreach($allcard as $k=>$v){
                    $data_arr[$k] = ($v-$min); 
                }
                //dd($allcard);   // key = prize_id , v = user_count; //$min 是数量  //删除数据
                $dataAll['user'] = $user;
                $dataAll['phone'] = $phone;
                $dataAll['desc'] = 'data数据下标是集卡id数值是总数';
                $dataAll['huodong_1'] = $card_arr[0]->desc . "数量是: " . $min;
                $dataAll['data_1'] = $data_arr;
                //删除抽奖记录里面的数据
                $has_del_data = array_keys($data_arr);
                //循环删除
                for($i = 0; $i < count($has_del_data);$i++){
                   Prize_logs::where([['mem_no',$user],['prize_id',$has_del_data[$i]]])->limit($min)->delete();    
                }
                return ['code'=>1,'data'=>$dataAll];
            };
            return ['code'=>0,'不符合活动一'];
    }

    //从抽奖记录里面获取到他所有的卡片
    public function allcard($user)
    {
        $data = Prize_logs::select(DB::raw('count(*) as user_count,p_img,p_name,dzp_prize_logs.prize_id,mem_no'))
                    ->leftJoin('prize','prize_logs.prize_id','prize.prize_id')
                    ->where([['mem_no',$user],['p_rules',0]])
                    ->groupBy('p_name')
                    ->get()
                    ->toArray(); 
        //转换为 key = prize_id , v = user_count;
        //dd($data);
        $arr = [];
        for($i=0;$i<count($data);$i++){
            $arr[$data[$i]['prize_id']] = $data[$i]['user_count'];
        }
        return $arr;
    }
}
