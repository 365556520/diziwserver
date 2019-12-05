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
                    <button class="layui-btn layui-btn-sm" onclick="addPermissions()">新增权限</button>
                    <button class="layui-btn layui-btn-primary  layui-btn-sm" onclick="reload()">刷新</button>
                </div>
                <b style="color:#cb0322 ">注意:修改权限完成后记得保存!</b>
            </script>

            <table class="layui-hide" id="permissions" lay-filter="permissions" lay-size="lg"></table>

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
                    {field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
                    ,{field:'name', title:'权限名字', width:220, edit: 'text' }
                    ,{field:'guard_name', title:'权限看守', width:300, edit: 'text'}
                    ,{field:'created_at', title:'创建时间', width:300 , sort: true}
                    , {
                        width: 200, title: '操作', align: 'center'/*toolbar: '#barDemo'*/
                        , templet: function (d) {
                            var html = '';
                            var saveBtn = '<a class="layui-btn  layui-btn-xs" lay-event="save">保存编辑</a>';
                            var delBtn = d.children.length>0?'':'<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                            return saveBtn + delBtn;
                        }
                    }
                ]]
            });
            treeGrid.on('tool(' + tableId + ')', function (obj) {
                if (obj.event === 'del') {//删除行
                    del(obj);
                }  else if (obj.event === "save") {//添加行
                    save(obj);
                }
            });
        });
        //删除权限
        function del(obj) {
            let id = obj.data.id; //获取id
            layer.confirm("你确定删除此权限吗？顶级权限必须在没有子菜单情况下可以删除！", {icon: 3, title: '提示'},
                function (index) {//确定回调
                    $.ajax({
                        type: "POST",
                        url: "{{url('/admin/permissions')}}/"+ id,
                        cache: false,
                        data:{_method:"DELETE", _token: "{{csrf_token()}}"},
                        success: function (data) {
                            layer.msg('删除成功', {
                                time: 2000, //20s后自动关
                            });
                            obj.del();
                            //删除成功后删除缓存
                            layer.close(index);
                        },
                        error: function (xhr, status, error) {
                            layer.msg('删除失败', {
                                time: 2000, //20s后自动关
                            });
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                        }
                    });
                }, function (index) {//取消回调
                    layer.close(index);
                }
            );
        }
        //新增权限
        function addPermissions() {
            layer.open({
                type: 2,//2类型窗口 这里内容是一个网址
                title: '<div><i class="layui-icon layui-icon-edit" style="font-size: 22px; color: #ff2315;"></i>添加权限</div>',
                shadeClose: true,
                shade: false,
                anim: 2, //打开动画
                maxmin: true, //开启最大化最小化按钮
                area: ['50%', '80%'],
                content: '{{url("/admin/permissions/create")}}',
                cancel: function(index, layero){
                    // 刷新表格
                    treeGrid.reload(tableId, {
                        page: {
                            curr: 1
                        }
                    });
                    return true;
                }
            });
        };
        //修改权限
        function save(obj) {
            let data =obj ? obj.data : null;
            console.log(obj, "更改权限？");
            if(data){
                $.ajax({
                    type: "post",
                    url: "{{url('/admin/permissions')}}/"+ data.id,
                    cache: false,
                    data:{
                        '_method':'PATCH',
                        id:data.id,
                        name : data.name,
                        guard_name :data.guard_name,
                        pid :data.pid,
                    },
                    headers: {
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                    },
                    success: function (data) {
                        layer.msg('保存成功', {
                            time: 2000, //20s后自动关
                        });
                        //成功后刷新当前行
                        treeGrid.updateRow(tableId,obj);
                    },
                    error: function (xhr, status, error) {
                        layer.msg('删除失败', {
                            time: 2000, //20s后自动关
                        });
                        console.log(xhr.responseJSON);
                        console.log(status);
                        console.log(error);
                    }
                });
            }
        }
        //刷新
        function reload() {
            treeGrid.reload(tableId, {
                page: {
                    curr: 1
                }
            });
        }
    </script>

@endsection
