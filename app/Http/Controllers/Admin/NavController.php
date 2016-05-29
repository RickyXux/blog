<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

class NavController extends CommonController
{
    //get.admin/nav   显示所有分类
    public function index()
    {
        $data = nav::orderBy('nav_id','desc')->paginate(10);    //分页显示
        return view('admin.nav.index',compact('data'));
    }

    //更改排序
    public function changeOrder()
    {
        $input = Input::all();
        $link = nav::find($input['nav_id']);
        $link['link_order'] = $input['link_order'];
        $re = $link -> update();
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


    //post.admin/nav   处理添加链接
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'link_name' => 'required',
            'link_url' => 'required'
        ];
        $message = [
            'link_name.required' => '链接名称不得为空！',
            'link_url.required' => '链接地址不得为空！'
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()) {
            $re = nav::create($input);
            if ($re) {
                return redirect('admin/nav');
            } else {
                return back()->with('errors','新增文章失败，请重试！');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    //get.admin/nav/create   添加友情链接
    public function create()
    {
        return view('admin/nav/add');
    }

    //get.admin/article/show   显示单个分类
    public function show()
    {

    }

    //delete.admin/nav/{nav}   删除单个分类
    public function destroy($nav_id)
    {
        $re = nav::where('nav_id',$nav_id)->delete();
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

    //put.admin/nav/{nav}   更新友情链接
    public function update($nav_id)
    {
        $input = Input::except('_method','_token');
        $rules = [
            'link_name' => 'required',
            'link_url' => 'required'
        ];
        $message = [
            'link_name.required' => '链接名称不得为空！',
            'link_url.required' => '链接地址不得为空！'
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()) {
            $re = nav::where('nav_id',$nav_id)->update($input);
            if ($re) {
                return redirect('admin/nav');
            } else {
                return back()->with('errors','友情链接修改失败，请重试！');
            }
        } else {
            return  withErrors($validator);
        }
    }

    //get.admin/nav/{nav}/edit   编辑单个分类
    public function edit($nav_id)
    {
        $field = nav::find($nav_id);
        return view('admin.nav.edit',compact('field'));
    }
}
