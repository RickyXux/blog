<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;


class CategoryController extends CommonController
{
    //get.admin/category   显示所有分类
    public function index()
    {
       $data=(new Category)->tree();
        // $data =Category::tree();

        return view('admin/category/index')->with('data',$data);
    }

    //更改排序
    public function changeOrder()
    {
        $input = Input::all();
        $category = Category::find($input['cate_id']);
        $category->cate_order=$input['cate_order'];
        $re = $category->update();
        if ($re) {
            $data=[
                'status'=>1,
                'msg'=>'修改排序成功！'
            ];
        } else {
            $data=[
                'status'=>0,
                'msg'=>'修改排序失败！'
            ];
        }
        return $data;
    }


    //post.admin/category
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'cate_name'=>'required'
        ];
        $message = [
            'cate_name.required'=>'分类名称不能为空！'
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()) {
            $re = Category::create($input);
            if ($re) {
                return redirect('admin/category');
            } else {
                return back()->with('errors','数据填充失败，请重试！');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    //get.admin/categroy/create   添加单个分类
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
        return view('admin/category/add',compact('data'));
    }

    //get.admin/category/show   显示单个分类
    public function show()
    {
        $data = Category::all();
        return view('admin/category',compact('data'));
    }

    //delete.admin/category/{category}   删除单个分类
    public function destroy($cate_id)
    {
        $re = Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
        if ($re) {
            $data = [
                'status' => 1,
                'msg' => '文章分类删除成功！'
            ];
        } else {
            $data = [
                'status' => 0,
                'msg' => '文章分类删除失败！'
            ];
        }
        return $data;
    }

    //put.admin/category/{category}   更新单个分类
    public function update($cate_id)
    {
        $input = Input::except('_token','_method');
        $re = Category::where('cate_id',$cate_id)->update($input);
        if ($re) {
            return redirect('admin/category');
        } else {
            return back()->with('errors','分类更新失败，请重试！');
        }
    }

    //get.admin/category/{category}/edit   编辑单个分类
    public function edit($cate_id)
    {
        $field = Category::find($cate_id);
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.edit',compact('data','field'));
    }
}
