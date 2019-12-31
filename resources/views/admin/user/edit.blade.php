@extends('layouts.layuicontent')
@section('title')
    <title>用户授权角色</title>
@endsection
@section('css')
@endsection
@section('content')
    <div>
        <br>
        <form class="layui-form " lay-filter="formTest" method="post" action="{{url('admin/user/'.$id)}}">
            @csrf
            {{method_field('PUT')}}
            <div class="layui-form-item">
                <label class="layui-form-label">选择角色:</label>
                <div class="layui-input-block">
                    @foreach($roles as $v)
                        @if($v->guard_name == 'web')
                        <input type="checkbox" name=check[{{$v->id}}] value={{$v->id}} title="{{$v->name}}">
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="layui-form-item" >
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="demo2">增加角色</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        layui.use(['form', 'layedit', 'laydate'], function() {
            var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit;
            //给表单赋值
            form.val("formTest", { //formTest 即 class="layui-form" 所在元素属性 lay-filter="" 对应的值
                @foreach($hasroles as $v)
                 "check[{{$v->role_id}}]":true,
                @endforeach
            });
            form.on('submit(demo2)', function(data){
                /*     layer.alert(JSON.stringify(data.field), {
                 title: '最终的提交信息'
                 })*/
                return true;
            });
        });
    </script>
@endsection



