@extends('layouts.layuicontent')
@section('title')
    <title>新增权限</title>
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
    <div class="layui-row" style="padding: 2px 15px 2px 15px;">
        <br>
       <form class="layui-form layui-form-pane" action="{{url('admin/permissions')}}" method="post">
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">菜单名字</label>
                <div class="layui-input-block">
                    <input type="text" name="name" lay-verify="required" autocomplete="off" placeholder="请输入菜单名称" class="layui-input">
                </div>
                @error('name') <div class="layui-form-mid error ">{{ $message }}</div>@enderror
            </div>
           <div class="layui-form-item">
               <label class="layui-form-label">权限分类</label>
                <div class="layui-input-block">
                    <select name="pid" lay-filter="aihao">
                        <option value=0 selected>顶级权限</option>
                        @foreach($permissions as $v)
                            @if($v->pid==0)
                                <option value={{$v->id}}>{{$v->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                @error('pid') <div class="layui-form-mid error ">{{ $message }}</div>@enderror
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">权限看守</label>
                <div class="layui-input-block">
                    <input type="text" name="guard_name" lay-verify="required" lay-reqtext="权限看守是必填项，岂能为空？" placeholder="请输入权限看守" autocomplete="off" class="layui-input">
                </div>
                @error('guard_name') <div class="layui-form-mid  error">{{ $message }}</div>@enderror
            </div>
            <div class="layui-form-item">
                <button class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="demo">新增顶级菜单</button>
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
            form.on('submit(demo)', function(data){
           /*     layer.alert(JSON.stringify(data.field), {
                    title: '最终的提交信息'
                })*/
                return true;
            });


        });
    </script>
@endsection
