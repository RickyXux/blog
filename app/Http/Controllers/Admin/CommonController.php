<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传
    public function upload() {
        $file = Input::file('Filedata');   //获取文件夹信息
        if ($file->isValid()) {
            $entension = $file -> getClientOriginalExtension();   //上传文件的后缀
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;   //将文件重新命名
            $path = $file -> move(base_path().'/uploads',$newName);   //移动文件到指定目录
            $filepath = 'uploads/'.$newName;   //设置返回后显示的路径
            return $filepath;
        } else {
            $data = 'fail';
            return $data;
        }
    }
}
