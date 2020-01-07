@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row">
        <table class="layui-hide" id="test" lay-filter="test"></table>
        <script type="text/html" id="toolbarDemo">
            <div class="layui-btn-container my-btn-box  layui-btn-group ">
                <button class="layui-btn layui-btn-xs" lay-event="add"><i class="layui-icon"></i></button>
                <button class="layui-btn layui-btn-warm layui-btn-xs" lay-event="isAll"><i class="layui-icon">&#xe669;</i></button>
            </div>
        </script>

    </div>
@endsection
@section('js')
    <script>
        layui.use('table', function(){
            var table = layui.table;
            // 表格渲染
            var tableIns = table.render({
                elem: '#test'
                , height: $(window).height() - ( $('.my-btn-box').outerHeight(true) ? $('.my-btn-box').outerHeight(true) + 35 :  40 )    //获取高度容器高度
                ,url:'/admin/goodsstock/ajaxIndex'
                ,toolbar: '#toolbarDemo'
                ,title: '商品进货'
                ,totalRow: true
                ,cols: [[
                    {field:'id', title:'ID', fixed: 'left',width:80, unresize: true, sort: true,totalRowText: '合计'}
                    ,{field:'goods_name', title:'商品名',width:200}
                    ,{field:'user_id', title:'用户id',width:120}
                    ,{field:'type', title:'单位',width:80}
                    ,{field:'count', title:'数量',width:80}
                    ,{field:'price', title:'实付',width:120,totalRow: true}
                    ,{field:'remark', title:'备注',width:200}
                    ,{field:'created_at', title:'创建时间',width:180, sort: true}
                    ,{fixed: 'right', title:'操作',width:180, toolbar: '#barDemo'}
                ]]
                , page: true
                , limits: [15, 25, 50, 100]
                , limit: 15 //默认采用30
            });

            //头工具栏事件
            table.on('toolbar(test)', function(obj){
                var checkStatus = table.checkStatus(obj.config.id);
                switch(obj.event){
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
                            title: '添加商品进货',
                            shadeClose: true,
                            shade: false,
                            anim: 2, //打开动画
                            maxmin: true, //开启最大化最小化按钮
                            area: ['893px', '100%'],
                            content: '{{url("/admin/goodsstock/create")}}',
                            cancel: function(index, layero){
                                // 刷新表格
                                tableIns.reload();
                                return true;
                            }
                        });
                        break;
                };
            });
            //监听行工具条事件
            table.on('tool(test)', function(obj){
                var data = obj.data;
                //console.log('kankan22222 '+obj.data);
                if(obj.event === 'del'){
                    layer.confirm('真的删除此分类吗？', function(index){
                        $.ajax({
                            type: "POST",
                            url: "{{url('/admin/goodsstock')}}/"+data.id,
                            cache: false,
                            data:{_method:"DELETE", _token: "{{csrf_token()}}","count":data.count,"goods_id":data.goods_id},
                            success: function (data) {
                                layer.msg('删除成功', {
                                    time: 2000, //20s后自动关
                                });
                                //删除成功后删除缓存
                                obj.del();
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
                } else if(obj.event === 'edit'){
                   layer.open({
                        type: 2,//2类型窗口 这里内容是一个网址
                        title: '修改商品进货',
                        shadeClose: true,
                        shade: false,
                        anim: 2, //打开动画
                        maxmin: true, //开启最大化最小化按钮
                        area: ['893px', '100%'],
                        content: '{{url("/admin/goodsstock")}}/'+ data.id + '/edit',
                       cancel: function(index, layero){
                           // 刷新表格
                           tableIns.reload();
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
                        ,title:'商品进货----'+data.goods_id
                        ,area: ['390px', '260px']
                        ,shade: 0
                        ,maxmin: true
                        ,content: '<div>进货单id：'+data.id +'<br>' +
                             '进货备注：'+data.remark +'<br>' +
                             '</div>'
                    });
                }
            });
        });
    </script>
@endsection
