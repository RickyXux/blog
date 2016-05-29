<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\User;
use App\Containers\Code;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class LoginController extends CommonController
{
    public function login() {
        if ($input = Input::all()) {
            $code = new Code;
            $_code=$code->get();
            if ($_code!=strtoupper($input['code'])) {
                return back()->with('msg','验证码错误！');
            }
            $user = User::first();
            if ($user->user_name != $input['user_name'] || $input['user_pass'] != Crypt::decrypt($user->user_pass)) {
                return back()->with('msg','用户名或密码错误！');
            }
            session(['user'=>$user]);
            return redirect('admin/index');
        } else {
            return view('admin.login');
        }

    }

    public function code() {
        $code = new Code;
        echo $code->make();
    }

    public function quit() {
        session(['user'=>null]);
        return redirect('admin/login');
    }

    public function crypt() {
        $str=123456;
        echo Crypt::encrypt($str);
        echo '<br/>';
        echo Crypt::decrypt('eyJpdiI6Ilh4WVdzd0Fkb1FKdGlKTEN0R1psRkE9PSIsInZhbHVlIjoiakFzSW45NjNFQTR1b0hhQlM2WWdHUT09IiwibWFjIjoiM2M0NDJhNzgxODRiYTVlYmZkNjg0MzdjOTJlMzVjODdkZTlkMDdhZTllY2E1OTZhMmFlNzI4ZWEwOGRhYzUwZiJ9');

    }
}
