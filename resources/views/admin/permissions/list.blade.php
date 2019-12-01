@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/permission.title')}}</title>
@endsection
@section('css')

@endsection
@section('content')
        <div >
            <script type="text/html" id="toolbarDemo">

            </script>
            <table class="layui-hide" id="permissions" lay-filter="permissions" lay-size="lg"></table>
            <script type="text/html" id="barDemo">
                <a class="layui-btn layui-btn-xs" lay-event="edit">保存</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            </script>
        </div>
@endsection
@section('js')
    <script>
        layui.use('table', function(){
            var table = layui.table;
            table.render({
                elem: '#permissions'
                ,url:'/admin/permissions/ajaxIndex'
                ,toolbar: '#toolbarDemo' //开启头部工具栏，并为其绑定左侧模板
                ,defaultToolbar: ['filter', 'exports', 'print', { //自定义头部工具栏右侧图标。如无需自定义，去除该参数即可
                    title: '提示'
                    ,layEvent: 'LAYTABLE_TIPS'
                    ,icon: 'layui-icon-tips'
                }]
                ,title: '用户数据表'
                ,height: 'full-50'
                ,width: '1100'
                ,cols: [[
                    {type: 'checkbox', fixed: 'left'}
                    ,{field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
                    ,{field:'name', title:'权限名字', width:220, edit: 'text' }
                    ,{field:'guard_name', title:'权限看守', width:300, edit: 'text'}
                    ,{field:'created_at', title:'创建时间', width:300 , sort: true}
                    ,{fixed: 'right', title:'操作', toolbar: '#barDemo', width:200}
                ]]
            });
        });
    </script>

@endsection
