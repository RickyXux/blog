@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/links')}}">友情链接</a> &raquo; 链接列表
</div>
<!--面包屑导航 结束-->
<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <div class="result_title">
            <h3>链接列表</h3>
         </div>
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>新增链接</a>
                <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>全部链接</a>
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
                    <th>标题</th>
                    <th>链接</th>
                    <th>操作</th>
                </tr>
                @foreach($data as $v)
                <tr>
                    <td class="tc">
                        <input type="text" name="link_order" onchange="changeOrder(this,{{$v->link_id}});" value="{{$v->link_order}}">
                    </td>
                    <td class="tc">{{$v->link_id}}</td>
                    <td>
                        <a href="#">{{$v->link_name}}</a>
                    </td>
                    <td>{{substr($v->link_title,0,130)}}...</td>
                    <td>{{$v->link_url}}</td>
                    <td>
                        <a href="{{url('admin/links/'.$v->link_id.'/edit')}}">修改</a>
                        <a href="javascript:;" onclick="delLinks({{$v->link_id}})">删除</a>
                    </td>
                </tr>
                @endforeach
            </table>


            <div class="page_list">
                {{$data->links()}}
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
    function changeOrder(obj,link_id) {
        var link_order = $(obj).val();
        $.post("{{url('admin/links/changeorder')}}",{'_token':'{{csrf_token()}}','link_id':link_id,'link_order':link_order},function (data) {
            if (data.status==0) {
                layer.msg(data.msg, {icon: 5});
            } else if (data.status==1) {
                location.href='links';
                layer.msg(data.msg, {icon: 6});
            }
        })
    }

    //删除文章分类
    function delLinks(link_id) {
        layer.confirm('您确定要删除此友情链接吗？',{
            btn: ['删除','保留']
        },function () {
            $.post("{{url('admin/links')}}"+"/"+link_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
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