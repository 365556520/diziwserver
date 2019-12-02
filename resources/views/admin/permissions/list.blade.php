@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/permission.title')}}</title>
@endsection
@section('css')

@endsection
@section('content')
        <div >
            <script type="text/html" id="toolbarDemo">
                <div class="layui-btn-container">
                    <button class="layui-btn layui-btn-sm" onclick="addPermissions()">新建权限</button>
                    <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>
                    <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button>
                </div>
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
        var  ptable = null, treeGrid = null, tableId = 'permissions', layer = null;
        // layui方法
        layui.config({
            base: '/extend/layui/extend/treeGrid/'//配置 layui 第三方扩展组件存放的基础目录
        }).extend({
            treeGrid: 'treeGrid' //定义该组件模块名
        }).use(['jquery', 'treeGrid', 'layer'], function () {
            var $ = layui.jquery;
            treeGrid = layui.treeGrid;//很重要
            layer = layui.layer;
            ptable = treeGrid.render({
                id: tableId
                ,elem: '#' + tableId
                ,url:'/admin/permissions/ajaxIndex'
                ,toolbar: '#toolbarDemo' //开启头部工具栏，并为其绑定左侧模板
                , idField: 'id'//必須字段
                , treeId: 'id'//树形id字段名称
                , treeUpId: 'pid'//树形父id字段名称
                , treeShowName: 'name'//以树形式显示的字段
                , heightRemove: [".dHead", 10]//不计算的高度,表格设定的是固定高度，此项不生效
                , height: '100%'
                , isFilter: false
                , iconOpen: false//是否显示图标【默认显示】
                , isOpenDefault: false//节点默认是展开还是折叠【默认展开】
                , loading: true
                , method: 'get'
                , isPage: false
                , limit: 1000 //默认采用100
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
        //保存数据
        function addPermissions() {
            console.log('新建权限');
        };
    </script>

@endsection
