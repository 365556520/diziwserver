@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        <form class="layui-form layui-form-pane" method="post" action="{{url('admin/role')}}">
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">{{trans('admin/role.model.name')}}</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
                @error('name') <div class="layui-form-mid error ">{{ $message }}</div>@enderror
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">{{trans('admin/role.model.display_name')}}</label>
                <div class="layui-input-inline">
                    <input type="text" name="guard_name" lay-verify="" placeholder="默认看守器是web，可以为空。" autocomplete="off" class="layui-input">
                </div>
                @error('guard_name') <div class="layui-form-mid error ">{{ $message }}</div>@enderror
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo2">添加角色</button>
            </div>
        </form>
    </div>
    @if(flash()->message)
        <div style="text-align:center;">
            <i class="layui-icon {{flash()->class}}">@if(flash()->class=='success')&#xe6af;@else&#xe69c;@endif {{flash()->message}}</i>
        </div>
    @endif
@endsection
@section('js')
    <script>
        layui.use(['form', 'layer',], function(){
            var form = layui.form
                ,layer = layui.layer;
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



