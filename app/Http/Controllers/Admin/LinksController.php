<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use App\Http\Models\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController
{
    //get.admin/links   显示所有分类
    public function index()
    {
        $data = Links::orderBy('link_id','desc')->paginate(10);    //分页显示
        return view('admin.links.index',compact('data'));
    }

    //更改排序
    public function changeOrder()
    {
        $input = Input::all();
        $link = Links::find($input['link_id']);
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


    //post.admin/links   处理添加链接
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
            $re = Links::create($input);
            if ($re) {
                return redirect('admin/links');
            } else {
                return back()->with('errors','新增文章失败，请重试！');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    //get.admin/links/create   添加友情链接
    public function create()
    {
        return view('admin/links/add');
    }

    //get.admin/article/show   显示单个分类
    public function show()
    {

    }

    //delete.admin/links/{links}   删除单个分类
    public function destroy($link_id)
    {
        $re = Links::where('link_id',$link_id)->delete();
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

    //put.admin/links/{links}   更新友情链接
    public function update($link_id)
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
            $re = Links::where('link_id',$link_id)->update($input);
            if ($re) {
                return redirect('admin/links');
            } else {
                return back()->with('errors','友情链接修改失败，请重试！');
            }
        } else {
            return  withErrors($validator);
        }
    }

    //get.admin/links/{links}/edit   编辑单个分类
    public function edit($link_id)
    {
        $field = Links::find($link_id);
        return view('admin.links.edit',compact('field'));
    }
}
