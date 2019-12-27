@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        <form class="layui-form layui-form-pane" method="post" action="{{url('admin/comments')}}">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label class="layui-form-label">主题id</label>
                <div class="layui-input-inline">
                    <input type="text" name="topic_id" lay-verify="required|number" placeholder="必填必须数字" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">主题类型</label>
                <div class="layui-input-inline">
                    <input type="text" name="topic_type"  placeholder="选填" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">评论用户id</label>
                <div class="layui-input-block">
                    <input type="text" name="from_uid" lay-verify="required|number"   placeholder="必填必须数字" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">目标用户id</label>
                <div class="layui-input-block">
                    <input type="text" name="to_uid" autocomplete="off" placeholder="选填必须数字" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">父子关系</label>
                <div class="layui-input-block">
                    <input type="text" name="comments_pid" lay-verify="required|number" value="0" placeholder="必填必须数字"    autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">评论内容</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" name="content" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo2">添加评论</button>
            </div>
        </form>
        @if(flash()->message)
            <div style="text-align:center;">
                <i class="layui-icon {{flash()->class}}">@if(flash()->class=='success')&#xe6af;@else&#xe69c;@endif {{flash()->message}}</i>
            </div>
        @endif
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


        });
    </script>
@endsection
