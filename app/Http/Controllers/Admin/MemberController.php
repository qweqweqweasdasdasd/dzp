<?php

namespace App\Http\Controllers\Admin;

use DB;
use Hash;
use Validator;
use App\Http\Models\Cj;
use App\Http\Models\Member;
use Illuminate\Http\Request;
use App\Http\Models\Activity;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
	//导入数据
    public function import(Request $request)
    {
    	if($request->isMethod('post')){
    		//判断是否为空
    		if(!$_FILES['file']['name']){
    			return ['code'=>0,'error'=>'上传文件不得为空,请导入后缀为csv文件!'];
    		};
    		$ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);	//PATHINFO_EXTENSION => csv, 
    		//判断上传文件后缀名为 csv
    		if($ext != 'csv'){
    			return ['code'=>0,'error'=>'上传文件格式不对,请导入".csv"文件!'];
    		};	
    		//拼接路径
    		$file_path = './uploads/' . 'IM_DZP_member_data.' . $ext;
    		//把临时文件转移到服务器上
    		$status = move_uploaded_file($_FILES['file']['tmp_name'],$file_path);
    		if(!$status){
    			return ['code'=>0,'error'=>'上传文件失败,请重新上传!'];
    		};
    		$handle = fopen($file_path,'rb');
    		//将文件一次性打开
    		$datas = array();
    		while($row = fgetcsv($handle)){
    			$datas[] = $row;
    		}
    		if(count($datas) > 50000){
    			return ['code'=>0,'error'=>'导入数据不得大于5万!'];
    		}
    		//把数据切为5000一份
    		$chunk_datas = array_chunk($datas, '5000');
    		$count = count($chunk_datas);
    		$mg_name = \Auth::guard('back')->user()->username;		//当前管理员
    		$order = 'M_IM_DZP_' . mt_rand(100000,999999);		//生成订单号
    		$activity_type = $request->input('radio');	//获取是什么活动的数据
    		for($i=0; $i<$count; $i++) { 
    			$sqlstr = "";
    			foreach($chunk_datas[$i] as $value){
    				$mem_no = mb_convert_encoding($value[0],'utf-8','gbk');
    				$mem_name = mb_convert_encoding($value[1],'utf-8','gbk');
    				$mem_pwd = mb_convert_encoding($value[2],'utf-8','gbk');
    				$mem_mobile = mb_convert_encoding($value[3],'utf-8','gbk');
    				$cj_sum = mb_convert_encoding($value[4],'utf-8','gbk');
    				$created_at = date('Y-m-d H:i:s',time());
    				//第二次导入数据会产生重复数据或者新数据
    				$data = $this->second_import($mem_no,$mem_name,$mem_pwd,$mem_mobile,$mg_name,$order,$created_at,$activity_type,$cj_sum);
    				//$str = "('$mem_no','$mem_name','$mem_pwd','$mem_mobile','$mg_name','$order','$created_at','$activity_type','$cj_sum'),";
                    //dd($data);
    			}
    		}
    		fclose($handle);
            return ['code'=>1,'error'=>'ok'];
    	}
    	$activity = Activity::get();
    	$count = Member::count();
    	return view('admin.member.import',compact('activity','count'));
    }

    //数据回滚  未开发
    public function rollback(Request $request,$order)
    {
        //获取到记录里面所有的数值然后找到会员的次数减去,
        //删除所有的同一个批号的记录

        //dd($order);
    }
    //第二次导入数据
    public function second_import($mem_no,$mem_name,$mem_pwd,$mem_mobile,$mg_name,$order,$created_at,$activity_type,$cj_sum)
    {
    	//从数据库内查询是否有重复的数据
    	$res = Member::where([	//会员账号,抽奖类型一致
	    		['mem_no','=',$mem_no],
	    		['activity_type','=',$activity_type]
    		])->first();

    	if($res == null){	//没有重复=>新数据
            $mem_id = Member::insertGetId([             //记录会员
                        'mem_no'=>$mem_no,
                        'mem_name'=>$mem_name,
                        'mem_pwd'=>Hash::make($mem_pwd),
                        'mem_mobile'=>$mem_mobile,
                        'mg_name'=>$mg_name,
                        'order'=>$order,
                        'created_at'=>$created_at,
                        'activity_type'=>$activity_type,
                        'cj_sum'=>$cj_sum,
                    ]);
    		
            $cj_id = Cj::insertGetId([                  //记录中间表
                'count'=>$cj_sum,
                'mem_id'=>$mem_id,
                'created_at'=>date('Y-m-d H:i:s',time()),
                'activity_type'=>$activity_type,
                'order'=>$order
            ]);
    		return ['msg'=>true];	//把新数据字符串返回		
    	};
    	//数据更新的逻辑
    	$cj_sum_z = (string)($res->cj_sum + $cj_sum);		//计算抽奖的总次数
    	$cj_id = Cj::insertGetId([	//记录中间表
    		'count'=>$cj_sum,
    		'mem_id'=>$res['id'],
    		'created_at'=>date('Y-m-d H:i:s',time()),
    		'activity_type'=>$activity_type,
            'order'=>$order
    	]);
    	DB::table('member')->where('id',$res['id'])->update(['cj_sum'=>$cj_sum_z]);//数据更新,'cj_id'=>$cj_id
        return ['msg'=>true];
    }

    //活动类型/批号查询
    public function search(Request $request)
    {
    	if($request->isMethod('post')){
    		$data = $request->all();
    		//获取当前页码
    		$page = ($request->input('page')!= null)?$request->input('page'):1;
    		//显示长度
    		$pagesize = 9;
    		//计算偏移量
    		$offset = ($page-1) * $pagesize;
    		//echo $offset;
    		//var_dump($request->all());
    		$datas = DB::table('cj')->select('cj.id','cj.order','cj.activity_type','cj.created_at','member.mg_name','activity.name')
                    ->leftJoin('activity','cj.activity_type','activity.id')
                    ->leftJoin('member','cj.mem_id','member.id')
    				->where('cj.activity_type',$data['activity_type'])
                    ->groupBy('cj.order')
    				->offset($offset)
    				->limit($pagesize)	//显示多少个数据
    				->get();
    		//return $datas;
 			$count = $datas->count();
 			$total = DB::table('cj')->leftJoin('activity','cj.activity_type','activity.id')
                            ->where('activity_type',$data['activity_type'])
                            ->groupBy('cj.order')
		    				->count();
		    $pagemax = ceil($total/$pagesize);

    		$html = "";
    		foreach($datas as $v){
	    		$html .= '<tr class="text-c">';
				$html .= '<td>'.$v->id.'</td>';
				/*$html .= '<td>'.$v->mem_no.'</td>';
				$html .= '<td>'.$v->mem_name.'</td>';*/
				/*$html .= '<td>'.$v->mem_pwd.'</td>';
				$html .= '<td>'.$v->mem_mobile.'</td>';*/
				/*$html .= '<td>'.$v->cj_sum.'</td>';*/     //抽奖次数不要
				$html .= '<td>'.$v->order.'</td>';
				$html .= '<td>'.$v->name.'</td>';
				$html .= '<td>'.$v->created_at.'</td>';
				$html .= '<td>'.$v->mg_name.'</td>';
				$html .= '<td class="td-manage">
							<a class="btn btn-primary" title="数据回滚" href="javascript:;" onclick="member_del(this,\'' . $v->order . '\')"  >数据回滚</a> 
						</td>';
				$html .= '</tr>';
    		};
    		$pages = '<div id="links">';
    		$pages .= '<ul class="pagination">';
    		$pages .= '<li><a href="#" onclick="getData(';
    		$pages .=  $page<=1?$page:$page-1; 
    		$pages .= ')">上一页</a></li>';
    		$pages .= '<li><a href="#" onclick="getData(';
    		$pages .=  $page>=$pagemax?$pagemax:$page+1;
    		$pages .= ')">下一页</a></li>';
    		$pages .= '</ul>';
    		$pages .= '</div>';
    		//echo $page+1;
    		return ['code'=>1,'datas'=>$html,'count'=>$count,'pages'=>$pages];
    	}
    }

    //会员列表操作
    public function index(Request $request)
    {
        error_reporting(0);     //关闭所有的错误
        $input = $request->all();
        $data = Member::select('member.id','mem_no','mem_pwd','mem_mobile','mem_name','cj_sum','activity.name','activity_type','member.created_at')
                        ->leftJoin('activity','member.activity_type','activity.id')
                        ->where(function($query) use($input){
                            if(!empty($input['keyword'])){  //关键字存在
                                $query->where([['mem_no',$input['keyword']],['activity_type',$input['activity_type']]]);
                            }else if(!empty($input['activity_type'])){
                                $query->where('activity_type',$input['activity_type']);
                            }
                        })
                        ->paginate(11);
        $activity = Activity::get();
        return view('admin.member.index',compact('data','activity','input'));
    }

    //实时编辑
    public function real_edit(Request $request)
    {
        if($request->isMethod('post')){
            if(is_numeric($request->input('newtext'))){
                Member::where('id',$request->input('id'))->update(['mem_mobile'=>$request->input('newtext')]);   
                return ['code'=>1,'i'=>$request->input['newtext']];
            };
            $z = Member::where('id',$request->input('id'))->update(['mem_name'=>$request->input('newtext')]);
            //dd($request->input('newtext'));
            return ['code'=>1,'i'=>$request->input['newtext']];
        }
    }

    //会员密码修改
    public function reset_pwd(Request $request,$id)
    {
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(),
                ['new_pwd'=>'required|max:225'],
                ['new_pwd.required'=>'密码没有重置哦!','new_pwd.max'=>'密码不得超出225个字符!']
            );
            if($validator->passes()){
                //数据验证OK
                $mem_pwd = \Hash::make($request->input('new_pwd'));
                Member::where('id',$id)->update(['mem_pwd'=>$mem_pwd]);
                return ['code'=>1];
                //dd();
            }
            $error = collect($validator->messages())->implode('0', '|');
            return ['code'=>0,'error'=>$error];
            //dd($request->all());
        }
        $info = Member::where('id',$id)->first();
        return view('admin.member.reset_pwd',compact('info'));
    }

    //会员删除
    public function del(Request $request,$id)
    {
        if($request->isMethod('post')){
            Member::where('id',$id)->delete();
            return ['code'=>1];
        }
    }

    //会员兑换
    public function show(Request $request)
    {
        error_reporting(0);
        $keyword = $_GET['keyword'];
        //dd($keyword);
        //派送彩金的活动 ==> 集卡的话不显示,
        $prize_logs = DB::table('prize_logs')
                        ->select('logs_id','mem_no','p_name','p_rules','status','prize_logs.created_at')
                        ->leftJoin('prize','prize_logs.prize_id','prize.prize_id')
                        ->where(function($query) use($keyword){
                            if(!empty($keyword)){
                                $query->where('mem_no',$keyword);
                            }else{
                                $query->where('prize.p_rules','1');
                            }
                        })
                        ->orderBy('logs_id','desc')
                        ->paginate(11);
        $count = $prize_logs->count();
        //dd($prize_logs);
        return view('admin.member.show',compact('prize_logs','count','keyword'));
    }

    //轮询最新抽奖记录
    public function newdata(Request $request)
    {
        //从抽奖记录查询没有处理的数据
        $newdata = DB::table('prize_logs')
                        ->leftJoin('prize','prize_logs.prize_id','prize.prize_id')
                        ->where([['status','0'],['p_rules','1']])
                        ->first();
        //dd($newdata);
        if($newdata){
            return ['code'=>1];
        }
        return ['cdoe'=>0];
    }

    //派送完毕彩金
    public function sended(Request $request,$id)
    {
        //修改status字段
        $z = DB::table('prize_logs')->where('logs_id',$id)->update(['status'=>1]);
        if($z){
            return ['code'=>1];
        };
        return ['code'=>0];
    }

    //集卡兑换列表
    public function make(Request $request)
    {
        error_reporting(0);
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
        $data = DB::table('jika')
                ->where(function($query) use($keyword){
                    if(!empty($keyword)){
                        $query->where('user',$keyword);
                    }
                })
                ->orderBy('jika_id','desc')
                ->paginate(11);
        $count = $data->count();
        return view('admin.member.list',compact('data','count','keyword'));
    }

    //轮询集卡最新记录
    public function jika_new_data(Request $request)
    {
        if($request->isMethod('post')){
            $z = DB::table('jika')->whereNull('desc')->get()->toArray();
            //dd($z);
            if(!empty($z)){
                return ['code'=>1,'msg'=>'有最新的集卡活动提交的哦!'];
            }
            return ['code'=>0];
        }
    }   

    //集卡备注
    public function jikaset(Request $request,$id)
    {
        if($request->isMethod('post')){
            //dd($request->input('desc'));
            DB::table('jika')->where('jika_id',$id)->update(['desc'=>$request->input('desc')]);
            return ['code'=>1];
        }
        $info = DB::table('jika')->where('jika_id',$id)->first();
        return view('admin.member.jikaset',compact('id','info'));
    }
}
