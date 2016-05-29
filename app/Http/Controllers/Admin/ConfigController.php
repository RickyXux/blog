<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

class ConfigController extends CommonController
{
    //get.admin/config   显示所有配置
    public function index()
    {
        $data = config::orderBy('conf_id','desc')->paginate(10);    //分页显示
        return view('admin.config.index',compact('data'));
    }

    //更改排序
    public function changeOrder()
    {
        $input = Input::all();
        $conf = config::find($input['conf_id']);
        $conf['conf_order'] = $input['conf_order'];
        $re = $conf -> update();
        if ($re) {
            $data = [
                'status' => 1,
                'msg' => '更改排序成功！'
            ];
        } else {
            $data = [
                'status' => 0,
                'msg' => '更改排序失败，请重试！'
            ];
        }
        return $data;
    }


    //post.admin/config   处理添加链接
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'conf_name' => 'required',
            'conf_url' => 'required'
        ];
        $message = [
            'conf_name.required' => '链接名称不得为空！',
            'conf_url.required' => '链接地址不得为空！'
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()) {
            $re = config::create($input);
            if ($re) {
                return redirect('admin/config');
            } else {
                return back()->with('errors','新增文章失败，请重试！');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    //get.admin/config/create   添加友情链接
    public function create()
    {
        return view('admin/config/add');
    }

    //get.admin/article/show   显示单个分类
    public function show()
    {

    }

    //delete.admin/config/{config}   删除单个分类
    public function destroy($conf_id)
    {
        $re = config::where('conf_id',$conf_id)->delete();
        if ($re) {
            $data = [
                'status' => '1',
                'msg' => '友情链接删除成功！'
            ];
        } else {
            $data = [
                'status' => '0',
                'msg' => '友情链接删除失败！'
            ];
        }
        return $data;
    }

    //put.admin/config/{config}   更新友情链接
    public function update($conf_id)
    {
        $input = Input::except('_method','_token');
        $rules = [
            'conf_name' => 'required',
            'conf_url' => 'required'
        ];
        $message = [
            'conf_name.required' => '链接名称不得为空！',
            'conf_url.required' => '链接地址不得为空！'
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()) {
            $re = config::where('conf_id',$conf_id)->update($input);
            if ($re) {
                return redirect('admin/config');
            } else {
                return back()->with('errors','友情链接修改失败，请重试！');
            }
        } else {
            return  withErrors($validator);
        }
    }

    //get.admin/config/{config}/edit   编辑单个分类
    public function edit($conf_id)
    {
        $field = config::find($conf_id);
        return view('admin.config.edit',compact('field'));
    }
}
