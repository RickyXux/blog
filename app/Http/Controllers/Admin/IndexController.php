<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    public function index() {
        return view('admin.index');
    }

    public function info() {
        return view('admin.info');
    }

    //修改密码
    public function pass() {
        if ($input = Input::all()) {
            //验证规则
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];
            //错误信息
            $message = [
                'password.required'=>'新密码不能为空！',
                'password.between'=>'新密码必须是6-20位！',
                'password.confirmed'=>'新密码和确认密码不一致！',
            ];
            $validator = Validator::make($input,$rules,$message);
            if ($validator->passes()) {
                $user=User::first();
                $_password=Crypt::decrypt($user['user_pass']);
                if ($_password!=$input['password_o']) {
                    return back()->with('errors','原密码错误！');
                } else {
                    $user->user_pass=Crypt::encrypt($input['password']);
                    $user->update();
                    return redirect('admin/info');
                }
            } else {
                return back()->withErrors($validator);
            }
        } else {
            return view('admin/pass');
        }
    }
}
