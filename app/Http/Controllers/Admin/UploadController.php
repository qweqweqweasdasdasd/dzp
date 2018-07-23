<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
    	if($request->isMethod('post')){
    		//判断是否为空
    		if(!is_uploaded_file($_FILES['file']['tmp_name'])){
    			return ['code'=>0,'error'=>'上传文件不得为空,上传文件属于图片形式!'];
    		}
    		//获取到文件的后缀名
    		$ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
    		$allow_ext = array('jpeg','png','jpg');
    		if(!in_array($ext,$allow_ext)){
    			return ['code'=>0,'error'=>'上传文件格式不对,后缀名为"jpeg","jpg","png"才可以!'];
    		};
    		//没有限制上传的文件大小
    		//拼接文件上传的路径
    		$file_path = "./images/sudoku-" . date('YmdHis') . '-' . mt_rand('10000','99999') . '.' . $ext;
    		$status = move_uploaded_file($_FILES['file']['tmp_name'],$file_path);
    		$url_path = substr($file_path,1);
    		if(!$status){
    			return ['code'=>0,'error'=>'文件上传失败,请重新上传!'];
    		}
    		return ['code'=>1,'url_path'=>$url_path];
    		//dd($request->all());
    	}
    }
}
