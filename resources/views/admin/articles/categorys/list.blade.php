@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')

    <div class="layui-row">
        <table class="layui-hide" id="test" lay-filter="test"></table>
        <script type="text/html" id="barDemo">
            <div class="layui-btn-container layui-btn-group my-btn-box">
                <button class="layui-btn layui-btn-danger  layui-btn-xs" lay-event="getCheckData">批量删除</button>
                <button class="layui-btn layui-btn-normal layui-btn-xs" lay-event="getCheckLength">获取选中数目</button>
                <button class="layui-btn layui-btn-warm layui-btn-xs" lay-event="isAll">刷新</button>
                <button class="layui-btn layui-btn-xs" lay-event="add">添加分类</button>
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
                ,url:'/admin/categorys/ajaxIndex'
                ,toolbar: '#barDemo' //开启头部工具栏，并为其绑定左侧模板
                , idField: 'id'//必須字段
                , treeId: 'id'//树形id字段名称
                , treeUpId: 'cate_pid'//树形父id字段名称
                , treeShowName: 'cate_name'//以树形式显示的字段
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
                    {type: 'checkbox', fixed: 'left'}
                    ,{field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
                    ,{field:'cate_name', title:'分类名称', width:120}
                    ,{field:'cate_keywords', title:'关键词', width:120, edit: 'text',}
                    ,{field:'cate_description', title:'描述', width:200, edit: 'text',}
                    ,{field:'cate_view', title:'查看次数', width:120}
                    ,{field:'cate_pid', title:'PID', width:120}
                    ,{field:'created_at', title:'创建时间', width:180, sort: true}
                    ,{field:'updated_at', title:'更新时间', width:180}
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

            //头工具栏事件
            treeGrid.on('toolbar(' + tableId + ')', function(obj){
                var checkStatus = table.checkStaptus(obj.config.id);
                switch(obj.event){
                    case 'getCheckData':
                        var data = checkStatus.data;  //得到选中数据的数组
                        if(data.length>0){
                            layer.confirm('真的删除这些分类吗？', function(index){
                                $.ajax({
                                    type: "GET",
                                    url: "{{url('/admin/categorys/destroys')}}/"+ JSON.stringify(data),
                                    cache: false,
                                    success: function (data) {
                                        layer.msg(data.msg, {
                                            time: 2000, //20s后自动关
                                        });
                                        console.log('kankan22222 '+data.code);
                                        if(data.code === 200){
                                            // 刷新表格
                                            tableIns.reload({
                                                page: {
                                                    curr: 1 //重新从第 1 页开始
                                                }
                                            });
                                            //删除成功后删除缓存
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
                        }else {
                            layer.msg('最少选中一个');
                        }
                        break;
                    case 'getCheckLength':
                        var data = checkStatus.data;
                        layer.msg('选中了：'+ data.length + ' 个');
                        break;
                    case 'isAll':
                        // 刷新表格
                        tableIns.reload({
                            page: {
                                curr: 1 //重新从第 1 页开始
                            }
                        });
                        //layer.msg(checkStatus.isAll ? '全选': '未全选');
                        break;
                    case 'add':
                        layer.open({
                            type: 2,//2类型窗口 这里内容是一个网址
                            title: '添加文章分类',
                            shadeClose: true,
                            shade: false,
                            anim: 2, //打开动画
                            maxmin: true, //开启最大化最小化按钮
                            area: ['893px', '100%'],
                            content: '{{url("/admin/categorys/create")}}',
                            cancel: function(index, layero){
                                // 刷新表格
                                tableIns.reload({
                                    page: {
                                        curr: 1 //重新从第 1 页开始
                                    }
                                });
                                return true;
                            }
                        });
                        break;
                };
            });
            //监听行工具条事件
            treeGrid.on('tool(' + tableId + ')', function(obj){
                var data = obj.data;
                //console.log('kankan22222 '+obj.data);
                if(obj.event === 'del'){
                    layer.confirm('真的删除此分类吗？', function(index){
                        $.ajax({
                            type: "POST",
                            url: "{{url('/admin/categorys')}}/"+data.id,
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
                        title: '修改文章分类',
                        shadeClose: true,
                        shade: false,
                        anim: 2, //打开动画
                        maxmin: true, //开启最大化最小化按钮
                        area: ['893px', '100%'],
                        content: '{{url("/admin/categorys")}}/'+ data.id + '/edit',
                       cancel: function(index, layero){
                           // 刷新表格
                           tableIns.reload({
                               page: {
                                   curr: 1 //重新从第 1 页开始
                               }
                           });
                           return true;
                       }
                    });

                 /*   layer.prompt({
                        formType: 2
                        ,value:data.id
                    }, function(value, index){
                        obj.update({
                            cate_keywords: value
                        });
                        layer.close(index);
                    });*/
                } else if(obj.event === 'show'){
                    //多窗口模式，层叠置顶
                    layer.open({
                        type: 1 //1类型窗口 这里内容可以自己写
                        ,title:'文章分类----'+data.cate_name
                        ,area: ['390px', '260px']
                        ,shade: 0
                        ,maxmin: true
                        ,content: '<div>分类id：'+data.id +'<br>' +
                             '分类名称：'+data.cate_name +'<br>' +
                             '分类关键词：'+data.cate_keywords +'<br>' +
                             '分类描述：'+data.cate_description +'<br>' +
                             '</div>'
                    });
                }
            });
        });
    </script>
@endsection
