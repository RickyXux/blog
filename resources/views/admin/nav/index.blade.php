@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/nav')}}">导航菜单</a> &raquo; 菜单列表
</div>
<!--面包屑导航 结束-->
<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <div class="result_title">
            <h3>菜单列表</h3>
         </div>
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/nav/create')}}"><i class="fa fa-plus"></i>新增菜单</a>
                <a href="{{url('admin/nav')}}"><i class="fa fa-recycle"></i>全部菜单</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>
    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%">排序</th>
                    <th class="tc" width="5%">ID</th>
                    <th width="7%">名称</th>
                    <th>别名</th>
                    <th>地址</th>
                    <th>操作</th>
                </tr>
                @foreach($data as $v)
                <tr>
                    <td class="tc">
                        <input type="text" name="nav_order" onchange="changeOrder(this,{{$v->nav_id}});" value="{{$v->nav_order}}">
                    </td>
                    <td class="tc">{{$v->nav_id}}</td>
                    <td>
                        <a href="#">{{$v->nav_name}}</a>
                    </td>
                    <td>{{$v->nav_alias}}...</td>
                    <td>{{$v->nav_url}}</td>
                    <td>
                        <a href="{{url('admin/nav/'.$v->nav_id.'/edit')}}">修改</a>
                        <a href="javascript:;" onclick="delNav({{$v->nav_id}})">删除</a>
                    </td>
                </tr>
                @endforeach
            </table>


            <div class="page_list">
                {{$data->nav()}}
            </div>
            <style>
                .page_list ul li span {
                    padding: 6px 12px;
                    text-decoration: none;
                }
            </style>
        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->
<script>
    function changeOrder(obj,nav_id) {
        var nav_order = $(obj).val();
        $.post("{{url('admin/nav/changeorder')}}",{'_token':'{{csrf_token()}}','nav_id':nav_id,'link_order':nav_order},function (data) {
            if (data.status==0) {
                layer.msg(data.msg, {icon: 5});
            } else if (data.status==1) {
                location.href='nav';
                layer.msg(data.msg, {icon: 6});
            }
        })
    }

    //删除文章分类
    function delNav(nav_id) {
        layer.confirm('您确定要删除此导航菜单吗？',{
            btn: ['删除','保留']
        },function () {
            $.post("{{url('admin/nav')}}"+"/"+nav_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
                if (data.status==1) {
                    location.href = location.href;   //刷新页面
                    layer.msg(data.msg,{icon: 6});
                } else {
                    layer.msg(data.msg,{icon: 5});
                }
            })
        },function () {

        });
    }
</script>
@endsection