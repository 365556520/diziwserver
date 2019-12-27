@extends('admin.layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/user.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row">

        <div class="layui-col-xs12 layui-col-sm12 layui-col-md12">
            <!-- table -->
            <table class="layui-hide" id="dateTable" lay-filter="dateTable"></table>
            <br>
            <!-- 工具集 -->
            <script type="text/html" id="toolbarDemo">
                <div class="my-btn-box">
                    <span class="fl">
                        <div class="layui-btn-group">
                            <button class="layui-btn layui-btn-danger layui-btn-xs"  lay-event="delete-all">批量删除</button>
                            <button class="layui-btn btn-default btn-add layui-btn-xs"  lay-event="add">添加驾驶员</button>
                        </div>

                    </span>
                    <span class="fr">
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                    <select name="ifs" id="ifs" lay-verify="">
                                          <option value="driver_name">名字</option>
                                          <option value="driver_sex">性别</option>
                                          <option value="driver_permit">准驾车型</option>
                                          <option value="driver_age">年龄</option>
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
        layui.use(['table', 'layer'], function () {
            // 操作对象
            var table = layui.table
                , layer = layui.layer
                ,form = layui.form
                , $ = layui.jquery;
            // 表格渲染
            var tableIns = table.render({
                elem: '#dateTable'                  //指定原始表格元素选择器（推荐id选择器）
                , height: $(window).height() - ( $('.my-btn-box').outerHeight(true) ? $('.my-btn-box').outerHeight(true) + 35 :  40 )    //获取高度容器高度
                , id: 'dataCheck'
                , url: '/admin/driver/ajaxIndex'
                ,toolbar: '#toolbarDemo'
                , where: {'ifs':null,'reload':null} //设定异步数据接口的额外参数
                , method: 'get'
                , page: true
                , limits: [15, 25, 50, 100]
                , limit: 15 //默认采用30
                , loading: false
                , cols: [[                  //标题栏
                    {type: 'checkbox', fixed: 'left'}
                    , {field: 'id', title: 'ID', width: 60, sort: true,fixed: 'left'}
                    , {field: 'driver_name', title: '名字', width: 100 ,fixed: 'left'}
                    , {field: 'driver_age', title: '年龄', width: 70 ,sort: true}
                    , {field: 'driver_sex', title: '性别', width: 70 }
                    , {field: 'driver_phone', title: '联系电话', width: 150}
                    , {field: 'driver_permit', title: '准驾车型', width: 100}
                    , {field: 'driver_archive_number', title: '驾驶证档案编号', width: 160}
                    // , {field: 'state', title: '文章状态', width: 90}
                    ,{field:'driver_card', title:'驾驶证号', width:180, templet: '#switchTpl', unresize: true}
                    , {field: 'driver_qualification', title: '资格证号', width: 190}
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
                        var thumbs = new Array(); //图片变量
                        //获取图片和id
                        for (var k in data) {
                            ids.push({
                                'id' : data[k]['id'],
                            });
                            thumbs.push(data[k]['driver_photo']);
                        }
                        if(data.length>0){
                            layer.confirm('真的删除这些分类吗？', function(index){
                                $.ajax({
                                    type: "POST",
                                    url: "{{url('/admin/driver/destroys')}}/"+ JSON.stringify(ids),
                                    cache: false,
                                    data:{"thumb":thumbs},
                                    success: function (data) {
                                        if(data.code === 200){
                                            layer.msg(data.msg, {
                                                time: 2000, //20s后自动关
                                            });
                                            //刷新表格
                                            tableIns.reload();
                                            //删除成功后删除缓存
                                            layer.close(index);
                                        }else {
                                            layer.msg(data.msg, {
                                                time: 2000, //20s后自动关
                                            });
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
                    case 'add':
                        layer.open({
                            type: 2,//2类型窗口 这里内容是一个网址
                            title: '<div><i class="layui-icon layui-icon-edit" style="font-size: 22px; color: #ff2315;"></i>添加驾驶员</div>',
                            shadeClose: true,
                            shade: false,
                            anim: 2, //打开动画
                            maxmin: true, //开启最大化最小化按钮
                            area: ['85%', '100%'],
                            content: '{{url("/admin/driver/create")}}',
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
                    layer.confirm('真的删除此分类吗？', function(index){
                        $.ajax({
                            type: "POST",
                            url: "{{url('/admin/driver')}}/"+data.id,
                            cache: false,
                            data:{_method:"DELETE", _token: "{{csrf_token()}}"},
                            success: function (data) {
                                if(data.code === 200){
                                    layer.msg(data.msg, {
                                        time: 2000, //20s后自动关
                                    });
                                    //删除成功后删除缓存
                                    obj.del();
                                    layer.close(index);
                                }else {
                                    layer.msg(data.msg, {
                                        time: 2000, //20s后自动关
                                    });
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
                        title: '修改驾驶员信息',
                        shadeClose: true,
                        shade: false,
                        anim: 2, //打开动画
                        maxmin: true, //开启最大化最小化按钮
                        area: ['85%', '100%'],
                        content: '{{url("/admin/driver")}}/'+ data.id + '/edit',
                        cancel: function(index, layero){
                            // 刷新表格
                            tableIns.reload();
                            return true;
                        }
                    });
                } else if(obj.event === 'show'){
                    //多窗口模式，层叠置顶
                    layer.open({
                        type: 2 //1类型窗口 这里内容可以自己写
                        ,title:'<h3>'+data.driver_name+'</h3>'
                        ,area: ['40%', '90%']
                        ,shade: false
                        ,anim: 2 //打开动画
                        ,maxmin: true
                        ,content:'{{url("/admin/driver")}}/'+ data.id
                    });
                }
            });

        });
    </script>
    {{--提示代码--}}
    @include('component.errorsLayer')
@endsection
