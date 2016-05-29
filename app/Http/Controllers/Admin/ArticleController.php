<?php

namespace App\Http\Controllers\Admin;

use App\http\Models\Article;
use App\http\models\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //get.admin/article   显示所有分类
    public function index()
    {
        $data = Article::orderBy('art_id','desc')->paginate(10);    //分页显示
        return view('admin.article.index',compact('data'));
    }

    //更改排序
    public function changeOrder()
    {

    }


    //post.admin/article
    public function store()
    {
        $input = Input::except('_token');
        $input ['art_time'] = time();
        $rules = [
            'art_title' => 'required',
            'art_content' => 'required'
        ];
        $message = [
            'art_title.required' => '文章标题不得为空！',
            'art_content.required' => '文章内容不得为空！'
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()) {
            $re = Article::create($input);
            if ($re) {
                return redirect('admin/article');
            } else {
                return back()->with('errors','新增文章失败，请重试！');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    //get.admin/categroy/create   添加单个分类
    public function create()
    {
        $category = (new Category)->tree();
        return view('admin/article/add',compact('category'));
    }

    //get.admin/article/show   显示单个分类
    public function show()
    {

    }

    //delete.admin/article/{article}   删除单个分类
    public function destroy($art_id)
    {
        $re = Article::where('art_id',$art_id)->delete();
        if ($re) {
            $data = [
                'status' => '1',
                'msg' => '文章删除成功！'
            ];
        } else {
            $data = [
                'status' => '0',
                'msg' => '文章删除失败！'
            ];
        }
        return $data;
    }

    //put.admin/article/{article}   更新单个分类
    public function update($art_id)
    {
        $input = Input::except('_method','_token');
        $rules = [
            'art_title' => 'required',
            'art_content' => 'required'
        ];
        $message = [
            'art_title.required' => '文章标题不得为空！',
            'art_content.required' => '文章内容不得为空！'
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()) {
            $re = Article::where('art_id',$art_id)->update($input);
            if ($re) {
                return redirect('admin/article');
            } else {
                return back()->with('errors','文章修改失败，请重试！');
            }
        } else {
            return  withErrors($validator);
        }
        $re = Article::where('art_id',$art_id)->update();
    }

    //get.admin/article/{article}/edit   编辑单个分类
    public function edit($art_id)
    {
        $data = (new Category())->tree();
        $field = Article::find($art_id);
        return view('admin.article.edit',compact('data','field'));
    }
}
