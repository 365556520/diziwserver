@extends('admin.layouts.layuicontent')
@section('title')
    <title>修改备忘录</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        <div style="color: #ec162d;size:38px">@include('flash::message')<br></div>
        <form class="layui-form layui-form-pane" lay-filter="edit" method="post" action="{{url('admin/note/'.$noteEdit->id)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <input type="hidden" value="{{$noteEdit->id}}" name="id">
            <div class="layui-form-item">
                <label class="layui-form-label">标题</label>
                <div class="layui-input-inline">
                    <input type="text" name="title" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">用户id</label>
                <div class="layui-input-inline">
                    <input type="text" name="user_id"  placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">评论内容</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" name="content" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo2">确认修改</button>
            </div>
        </form>

    </div>
@endsection
@section('js')
    <script>
        layui.use(['form', 'layedit', 'laydate'], function(){
            var form = layui.form
                ,layer = layui.layer
            //监听提交
            form.on('submit(demo2)', function(data){
                /*     layer.alert(JSON.stringify(data.field), {
                 title: '最终的提交信息'
                 })*/
                return true;
            });
            //初始值
            form.val("edit", {
                "title": "{{$noteEdit->title}}"
                ,"user_id": "{{$noteEdit->user_id}}"
                ,"content": "{{$noteEdit->content}}"
            })
        });
    </script>
@endsection