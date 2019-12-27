@extends('admin.layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/user.title')}}</title>
@endsection
@section('css')
    <link href="{{ asset('/backend/myvebdors/layui/layui_ext/dtree/dtree.css')}}" rel="stylesheet">
    <link href="{{ asset('/backend/myvebdors/layui/layui_ext/dtree/font/dtreefont.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="layui-row">
        <div class="layui-col-xs3 layui-col-sm2 layui-col-md2" style="height: 550px;overflow:scroll">
            <!-- tree -->
            {{--<ul id="tree" class="tree-table-tree-box"></ul>--}}
            <ul id="tree" class="dtree" data-id="0"></ul>
        </div>
        <div class="layui-col-xs9 layui-col-sm10 layui-col-md10">
            <!-- table -->
            <table class="layui-hide" id="dateTable" lay-filter="dateTable"></table>
            <br>
            <!-- 工具集 -->
            <script type="text/html" id="toolbarDemo">
                <div class="my-btn-box">
                    <span class="fl">
                        <div class="layui-btn-group">
                            <button class="layui-btn layui-btn-danger layui-btn-xs"  lay-event="delete-all">批量删除</button>
                            <button class="layui-btn btn-default btn-add layui-btn-xs"  lay-event="add">添加车辆</button>
                        </div>
                    </span>
                    <span class="fr">
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                    <select name="ifs" id="ifs" lay-verify="">
                                          <option value="buses_name">车号</option>
                                          <option value="buses_boss">车主</option>
                                          <option value="buses_start_date">发车时间</option>
                                          <option value="buses_approve_date">审验时间</option>
                                    </select>
                            </div>
                            <div class="layui-input-inline">
                                <input type="text" autocomplete="off" name="reload" id="reload" placeholder="请输入搜索条件" class="layui-input">
                            </div>
                        </div>
                        <button class="layui-btn mgl-20" data-type="reload" lay-event="reload"><i class="layui-icon layui-icon-search"></i>   </button>
                    </span>
                </div>
            </script>

        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        // layui方法
        layui.config({
            base: '/backend/myvebdors/layui/layui_ext/dtree/'//配置 layui 第三方扩展组件存放的基础目录
        }).extend({
            dtree: 'dtree' //定义该组件模块名
        }).use(['tree' ,'table', 'layer', 'dtree'], function () {
            // 操作对象
            var table = layui.table
                , layer = layui.layer
                ,dtree = layui.dtree
                ,form = layui.form
                , $ = layui.jquery;
            // 表格渲染
            var tableIns = table.render({
                elem: '#dateTable'                  //指定原始表格元素选择器（推荐id选择器）
                , height: $(window).height() - ( $('.my-btn-box').outerHeight(true) ? $('.my-btn-box').outerHeight(true) + 35 :  40 )    //获取高度容器高度
                , id: 'dataCheck'
                , url: '/admin/buses/ajaxIndex'
                ,toolbar: '#toolbarDemo'
                , where: {'busesroute_ids':null,'busesroute_id': null,'ifs':null,'reload':null} //设定异步数据接口的额外参数
                , method: 'get'
                , page: true
                , limits: [15, 25, 50, 100]
                , limit: 15 //默认采用30
                , loading: false
                , cols: [[                  //标题栏
                    {type: 'checkbox', fixed: 'left'}
                    , {field: 'id', title: 'ID', width: 60, sort: true,fixed: 'left'}
                    , {field: 'buses_name', title: '车号', width: 120 ,fixed: 'left'}
                    , {field: 'buses_type', title: '车型', width: 90}
                    , {field: 'buses_sit', title: '核载', width: 90}
                    , {field: 'buses_approve_date', title: '车辆审验时间', width: 130}
                    // , {field: 'state', title: '文章状态', width: 90}
                    ,{field:'buses_insurance_date', title:'保险期限', width:130, templet: '#switchTpl', unresize: true}
                    , {field: 'buses_boss', title: '车主', width: 100 ,sort: true,}
                    , {field: 'buses_phone', title: '随车电话', width: 150}
                    , {field: 'buses_start_date', title: '发车时间', width: 120}
                    , {field: 'buses_end_date', title: '返回时间', width: 120}
                    , {fixed: 'right', title: '操作', width: 160, align: 'center', toolbar: '#barDemo'} //这里的toolbar值是模板元素的选择器
                ]]
                , done: function (res, curr, count) {
                    //如果是异步请求数据方式，res即为你接口返回的信息。
                    //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、count为数据总长度
                    console.log(res);

                    //得到当前页码
                    console.log(curr);

                    //得到数据总量
                    console.log(count);
                }
            });
            //搜索方法
            var active = {
                reload: function(){
                    //搜索
                    var reload = $('#reload').val();
                    var ifs = $('#ifs').val();
                    //执行重载
                    tableIns.reload({
                        where: {
                            'busesroute_ids':null,
                            'busesroute_id': null,
                            'ifs': ifs,
                            'reload': reload
                        },
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                    });
                }
            };

            //头工具栏事件
            table.on('toolbar(dateTable)', function(obj){
                var checkStatus = table.checkStatus(obj.config.id);
                switch(obj.event){
                    case 'delete-all':
                        var data = checkStatus.data;  //得到选中数据的数组
                        var ids = new Array(); //id变量
                        //获id
                        for (var k in data) {
                            ids.push({
                                'id' : data[k]['id'],
                            });
                        }
                        if(data.length>0){
                            layer.confirm('真的删除吗？', function(index){
                                $.ajax({
                                    type: "POST",
                                    url: "{{url('/admin/buses')}}/"+JSON.stringify(ids),
                                    cache: false,
                                    data:{_method:"DELETE", _token: "{{csrf_token()}}"},
                                    success: function (data) {
                                        layer.msg('删除成功', {
                                            time: 2000, //20s后自动关
                                        });
                                        //刷新
                                        tableIns.reload();
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
                        }else {
                            layer.msg('最少选中一个');
                        }
                        break;
                    case 'add':
                        layer.open({
                            type: 2,//2类型窗口 这里内容是一个网址
                            title: '<div><i class="layui-icon layui-icon-edit" style="font-size: 22px; color: #ff2315;"></i>添加文章</div>',
                            shadeClose: true,
                            shade: false,
                            anim: 2, //打开动画
                            maxmin: true, //开启最大化最小化按钮
                            area: ['80%', '100%'],
                            content: '{{url("/admin/buses/create")}}',
                            cancel: function(index, layero){
                                // 刷新表格
                                tableIns.reload();
                                return true;
                            }
                        });
                        break;
                    case 'reload':
                        var type = $(this).data('type');
                        active[type] ? active[type].call(this) : '';
                        break;
                };
            });
            //监听行工具条事件
            table.on('tool(dateTable)', function(obj){
                var data = obj.data;
                //console.log('kankan22222 '+obj.data);
                if(obj.event === 'del'){
                    var ids = new Array(); //id变量
                    ids.push({'id' : data.id,});
                    layer.confirm('真的删除吗？', function(index){
                        $.ajax({
                            type: "POST",
                            url: "{{url('/admin/buses')}}/"+JSON.stringify(ids),
                            cache: false,
                            data:{_method:"DELETE", _token: "{{csrf_token()}}"},
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
                        title: '修改文章分类',
                        shadeClose: true,
                        shade: false,
                        anim: 2, //打开动画
                        maxmin: true, //开启最大化最小化按钮
                        area: ['80%', '100%'],
                        content: '{{url("/admin/buses")}}/'+ data.id + '/edit',
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
                        type: 2 //1类型窗口 这里内容可以自己写
                        ,title:'<h3>'+data.buses_name+'</h3>'
                        ,area: ['80%', '90%']
                        ,shade: false
                        ,anim: 2 //打开动画
                        ,maxmin: true
                        ,content:'{{url("/admin/buses")}}/'+ data.id
                    });
                }
            });
            //树
            dtree.render({
                elem: "#tree",  //绑定元素
                initLevel:1,
                icon: ["0","-1"], // 使用
                //  url: "../json/case/tree.json"  //异步接口
                data:[
                    {
                        title:'全部车辆'
                        ,id:0
                        ,parentId : 0
                    },
                    @foreach($busesRoute as $v)
                    {
                        title:'{{$v->buses_start}}--{{$v->buses_midway}}--{{$v->buses_end}}'
                        ,id:'{{$v->id}}'
                        ,parentId : '{{$v->buses_pid}}'
                        @if($v->children)
                        ,basicData: {
                            @foreach($v->children as $k => $id)"{{$k}}":'{{$id->id}}',@endforeach
                        }
                            ,children:[
                                @foreach($v->children as $vs){
                                title:'{{$vs->buses_start}}--{{$vs->buses_midway}}--{{$vs->buses_end}}'
                                ,id:'{{$vs->id}}'
                                ,parentId : '{{$vs->buses_pid}}'
                                },
                                @endforeach
                            ]
                        @endif
                    },
                    @endforeach
                ],
            });
            //单击节点 监听事件
            dtree.on("node('tree')" ,function(param){
                console.log('点击树节点的属性'+JSON.stringify(param.param));
                if (param.param.parentId != 0) {
                    newbusesroute_id = param.param.nodeId;
                    // 加载中...
                    var loadIndex = layer.load(2, {shade: false});
                    // 关闭加载
                    layer.close(loadIndex);
                    // 刷新表格
                    tableIns.reload({
                        where: {'busesroute_id': newbusesroute_id==0?null:newbusesroute_id,'busesroute_ids':null,'ifs':null,'reload':null} //设定异步数据接口的额外参数
                        , page: {
                            curr: 1 //重新从第 1 页开始
                        }
                    });
                }else {
                    newbusesroute_ids = param.param.basicData;
                    // 加载中...
                    var loadIndex = layer.load(2, {shade: false});
                    // 关闭加载
                    layer.close(loadIndex);
                    // 刷新表格
                    tableIns.reload({
                        where: {'busesroute_ids':newbusesroute_ids,'busesroute_id':null,'ifs':null,'reload':null} //设定异步数据接口的额外参数
                        , page: {
                            curr: 1 //重新从第 1 页开始
                        }
                    });

                }
            });
        });
    </script>
    {{--提示代码--}}
    @include('component.errorsLayer')
@endsection
