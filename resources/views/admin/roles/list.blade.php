@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row">

        <div class="layui-card">
            <div class="layui-card-header">角色管理</div>
            <div class="layui-card-body">
                <table class="layui-hide" id="test" lay-filter="test"></table>
                <script type="text/html" id="toolbarDemo">
                    <div class="layui-btn-container layui-btn-group my-btn-box">
                        <button class="layui-btn layui-btn-xs" lay-event="add">{{trans('admin/role.action.create')}}</button>
                        <button class="layui-btn layui-btn-warm layui-btn-xs" lay-event="isAll">刷新</button>
                    </div>
                </script>
                {{--操作按钮--}}
                <script type="text/html" id="barbtn">
                    <div class="layui-btn-group">
                        <button class="layui-btn layui-btn-normal layui-btn-xs" lay-event="empower">授权</button>
                        <button class="layui-btn layui-btn-xs" lay-event="edit">保存编辑</button>
                        <button class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</button>
                    </div>
                </script>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        layui.use('table', function(){
            var table = layui.table;
            // 表格渲染
            var tableIns = table.render({
                elem: '#test'
               // , height: '100%'    //获取高度容器高度
                ,url:'/admin/role/ajaxIndex'
                ,toolbar: '#toolbarDemo'
                ,title: '{{trans('admin/role.desc')}}'
                ,cols: [[
                    {field:'id', title:'{{trans('admin/role.model.id')}}', width:80, fixed: 'left', unresize: true, sort: true}
                    ,{field:'name', title:'{{trans('admin/role.model.name')}}',  edit: 'text',width:200}
                    ,{field:'guard_name', title:'{{trans('admin/role.model.display_name')}}', edit: 'text', width:300}
                    ,{fixed:'right', title:'{{trans('admin/role.model.operate')}}', toolbar: '#barbtn', width:180}
                ]]
                , page: true
                , limits: [10, 30, 50, 100]
                , limit: 10 //默认采用30
                ,loading: false
            });

            //头工具栏事件
            table.on('toolbar(test)', function(obj){
                var checkStatus = table.checkStatus(obj.config.id);
                switch(obj.event){
                    case 'isAll':
                        isreload();
                        break;
                    case 'add':
                        add();
                        break;
                };
            });
            //监听行工具条事件
            table.on('tool(test)', function(obj){
                //console.log('kankan22222 '+obj.data);
                if(obj.event === 'del'){
                    del(obj);
                } else if(obj.event === 'edit'){
                    save(obj);
                } else if(obj.event === 'empower'){
                    //多窗口模式，层叠置顶
                    layer.open({
                        type: 2 //1类型窗口 这里内容可以自己写
                        ,title:'授权'
                        ,area: ['39%', '80%']
                        ,shade: 0
                        ,maxmin: true
                        ,content: '{{url("/admin/role")}}/'+ obj.data.id
                    });
                }
            });
            //添加角色
            function add() {
                layer.open({
                    type: 2,//2类型窗口 这里内容是一个网址
                    title: '{{trans('admin/role.create')}}',
                    shadeClose: true,
                    shade: false,
                    anim: 2, //打开动画
                    maxmin: true, //开启最大化最小化按钮
                    area: ['33%', '60%'],
                    content: '{{url("/admin/role/create")}}',
                    cancel: function(index, layero){
                        isreload();//刷新表格
                        return true;
                    }
                });
            }
            //删除角色
            function del(obj) {
                var data = obj ? obj.data : null;
                if(data.name==="admin"){
                    layer.msg('超级管理员不能删除！', {
                        time: 2000, //20s后自动关
                    });
                }else{
                    layer.confirm('真的删除此分类吗？', function(index){
                        $.ajax({
                            type: "POST",
                            url: "{{url('/admin/role')}}/"+data.id,
                            cache: false,
                            data:{_method:"DELETE", _token: "{{csrf_token()}}"},
                            success: function (data) {
                                layer.msg('删除成功', {
                                    time: 2000, //20s后自动关
                                });
                                obj.del();//删除对应的行
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
                    });
                }
            }
            //修改保存角色
            function save(obj) {
                var data = obj ? obj.data : null;
                console.log(obj, "更改角色？");
                if(data){
                    $.ajax({
                        type: "post",
                        url: "{{url('/admin/role')}}/"+ data.id,
                        cache: false,
                        data:{
                            '_method':'PATCH',
                            id:data.id,
                            name : data.name,
                            guard_name :data.guard_name,
                        },
                        headers: {
                            'X-CSRF-TOKEN':"{{csrf_token()}}",
                        },
                        success: function (data) {
                            layer.msg('保存成功', {
                                time: 2000, //20s后自动关
                            });
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
            //刷新表格
            function isreload() {
                // 刷新表格
                tableIns.reload({
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                });
            }
        });
    </script>
@endsection
