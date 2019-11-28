@extends('layouts.layuicontent')
@section('title')
    <title>添加顶级菜单</title>
@endsection
@section('css')
    <style>
        .success{
            color: #5ccb22;
            font-size:28px;
        }
        .flasherror{
            font-size:28px;
            color: #cb0322;
        }
        .error{
            color: #cb0322;
        }
    </style>
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px;text-align:center">
        <br>
       <form class="layui-form layui-form-pane" action="{{url('admin/menu')}}" method="post">
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">菜单名称</label>
                <div class="layui-input-block">
                    <input type="text" name="name" lay-verify="required" autocomplete="off" placeholder="请输入菜单名称" class="layui-input">
                </div>
                @error('name') <div class="layui-form-mid error ">{{ $message }}</div>@enderror
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">菜单url</label>
                <div class="layui-input-block">
                    <input type="text" name="url" lay-verify="required" lay-reqtext="菜单url是必填项，岂能为空？" placeholder="请输入菜单url" autocomplete="off" class="layui-input">
                </div>
                @error('url') <div class="layui-form-mid  error">{{ $message }}</div>@enderror
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">菜单权限</label>
                <div class="layui-input-block">
                    <input type="text" name="slug" lay-verify="required" lay-reqtext="菜单权限是必填项，岂能为空？" placeholder="请输入菜单权限" autocomplete="off" class="layui-input">
                </div>
                @error('slug') <div class="layui-form-mid error">{{ $message }}</div>@enderror
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">图标</label>
                <div class="layui-input-block">
                    <input type="text" name="icon" lay-verify="" autocomplete="off" placeholder="请输入标题" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-block">
                    <input type="text" name="sort" lay-verify="required" autocomplete="off" placeholder="请输入排序" class="layui-input">
                </div>
                @error('sort') <div class="layui-form-mid error" >{{ $message }}</div>@enderror
            </div>
            <input type="text" name="parent_id" value=0 hidden>  {{--因为只添加顶级菜单所以pid固定是0--}}
            <div class="layui-form-item">
                <button class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="demo">新增顶级菜单</button>
            </div>
        </form>
        @if(flash()->message)
            <div >
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
            form.on('submit(demo)', function(data){
           /*     layer.alert(JSON.stringify(data.field), {
                    title: '最终的提交信息'
                })*/
                return true;
            });


        });
    </script>
@endsection
