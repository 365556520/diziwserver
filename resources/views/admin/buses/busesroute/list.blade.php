@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/user.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row">

        <table class="layui-hide" id="test" lay-filter="test"></table>
        <script type="text/html" id="barDemo">
            <div class="layui-btn-container layui-btn-group my-btn-box">
                <button class="layui-btn layui-btn-warm layui-btn-xs" lay-event="isAll" onclick="reload()">刷新</button>
                <button class="layui-btn layui-btn-xs" lay-event="add" onclick="add()">添加分类</button>
                <button class="layui-btn layui-btn-normal layui-btn-xs" lay-event="add" onclick="openAll()">全部展开或折叠</button>
            </div>
        </script>
    </div>
@endsection
@section('js')
    <script>
        var  ptable = null, treeGrid = null, tableId = 'test', layer = null;
        // layui方法
        layui.config({
            base: '/extend/layui/extend/treeGrid/'//配置 layui 第三方扩展组件存放的基础目录
        }).extend({
            treeGrid: 'treeGrid' //定义该组件模块名
        }).use(['jquery', 'treeGrid', 'layer'], function(){
            var $ = layui.jquery;
            treeGrid = layui.treeGrid;//很重要
            layer = layui.layer;
            // 表格渲染
            ptable = treeGrid.render({
                id: tableId
                ,elem: '#' + tableId
                ,url:'/admin/busesroute/ajaxIndex'
                ,toolbar: '#barDemo' //开启头部工具栏，并为其绑定左侧模板
                , idField: 'id'//必須字段
                , treeId: 'id'//树形id字段名称
                , treeUpId: 'buses_pid'//树形父id字段名称
                , treeShowName: 'buses_start'//以树形式显示的字段
                , heightRemove: [".dHead", 10]//不计算的高度,表格设定的是固定高度，此项不生效
                , isFilter: false
                , iconOpen: false//是否显示图标【默认显示】
                , isOpenDefault: false//节点默认是展开还是折叠【默认展开】
                , loading: true
                , method: 'get'
                , isPage: false
                , limit: 1000 //默认采用100
                , height: $(window).height() - ( $('.my-btn-box').outerHeight(true) ? $('.my-btn-box').outerHeight(true) + 35 :  40 )    //获取高度容器高度
                ,title: '用户数据表'
                ,cols: [[
                    {field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
                    ,{field:'buses_start', title:'起点', width:200}
                    ,{field:'buses_midway', title:'途径', width:400}
                    ,{field:'buses_end', title:'终点', width:150}
                    ,{field:'buses_pid', title:'PID', width:80}
                    ,{field:'created_at', title:'创建时间', width:180, sort: true}
                    , {
                        width: 200, title: '操作', align: 'center'/*toolbar: '#barDemo'*/
                        , templet: function (d) {
                            var html = '';
                            var saveBtn = '<a class="layui-btn  layui-btn-xs" lay-event="edit">编辑</a>';
                            var delBtn = d.children.length>0?'':'<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                            return saveBtn + delBtn;
                        }
                    }
                ]]
            });

            //监听行工具条事件
            treeGrid.on('tool(' + tableId + ')', function(obj){
                var data = obj.data;
                //console.log('kankan22222 '+obj.data);
                if(obj.event === 'del'){
                    layer.confirm('真的删除此分类吗？', function(index){
                        $.ajax({
                            type: "POST",
                            url: "{{url('/admin/busesroute')}}/"+data.id,
                            cache: false,
                            data:{_method:"DELETE", _token: "{{csrf_token()}}"},
                            success: function (data) {
                                layer.msg(data.msg, {
                                    time: 2000, //20s后自动关
                                });
                                if(data.code === 200){
                                    //删除成功后删除缓存
                                    obj.del();
                                    layer.close(index);
                                }
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
                    });
                } else if(obj.event === 'edit'){
                    layer.open({
                        type: 2,//2类型窗口 这里内容是一个网址
                        title: '修改线路',
                        shadeClose: true,
                        shade: false,
                        anim: 2, //打开动画
                        maxmin: true, //开启最大化最小化按钮
                        area: ['893px', '100%'],
                        content: '{{url("/admin/busesroute")}}/'+ data.id + '/edit',
                        cancel: function(index, layero){
                            // 刷新表格
                            treeGrid.reload(tableId,{
                                page: {
                                    curr: 1 //重新从第 1 页开始
                                }
                            });
                            return true;
                        }
                    });
                }
            });

        });
        //添加分类
        function add() {
            layer.open({
                type: 2,//2类型窗口 这里内容是一个网址
                title: '添加线路',
                shadeClose: true,
                shade: false,
                anim: 2, //打开动画
                maxmin: true, //开启最大化最小化按钮
                area: ['893px', '100%'],
                content: '{{url("/admin/busesroute/create")}}',
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
        }
        //展开和合并
        function openAll() {
            var treedata = treeGrid.getDataTreeList(tableId);
            treeGrid.treeOpenAll(tableId, !treedata[0][treeGrid.config.cols.isOpen]);
        }
        //刷新
        function reload() {
            treeGrid.reload(tableId,{
                page:{
                    curr:1
                }
            });
        };
    </script>
@endsection
