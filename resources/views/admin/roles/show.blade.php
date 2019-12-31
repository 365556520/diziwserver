@extends('layouts.layuicontent')
@section('title')
    <title>角色授权权限</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row" style="text-align:center;">
        <br>
        <div id="rolePermissions" class="demo-transfer"></div>
    </div>
@endsection
@section('js')
    <script>
        layui.use(['form', 'transfer', 'layer', 'util'], function(){
            var $ = layui.$
                ,form = layui.form
                ,layer = layui.layer
                ,transfer = layui.transfer
                ,util = layui.util;
            //数据源
            var permissions =[@foreach($role->permissions as $v){'value':'{{$v->id}}','title':'{{$v->name}}'},@endforeach]; //未选中的权限
            var role_permission = [@foreach($role->role_permission as $v)'{{$v}}',@endforeach]; //选中的权限
            //显示搜索框
            transfer.render({
                elem: '#rolePermissions'
                ,data: permissions
                ,value: role_permission
                ,title: ['未授权的权限', '已授权的权限']
                ,showSearch: true
                ,onchange: function(data, index){
                    console.log(data); //得到当前被穿梭的数据
                    console.log(index); //如果数据来自左边，index 为 0，否则为 1
                    var permission = [];
                    for (var i = 0; i < data.length; i++) {
                        permission[i]=data[i]['title'];
                    }
                    if(index==0){//添加权限
                        $.ajax({
                            type: "POST",
                            url: "/admin/role/upPermission",
                            cache: false,
                            data:{'permissions':permission,'id':"{{$role->id}}"},
                            success: function (data) {
                                layer.msg('授权成功');
                            },
                            error: function (xhr, status, error) {
                                layer.msg('授权失败');
                                console.log(xhr);
                                console.log(status);
                                console.log(error);
                            }
                        });
                    }else{ //撤销权限
                        $.ajax({
                            type: "POST",
                            url: "/admin/role/destroyPermission",
                            cache: false,
                            data:{'permissions':permission,'id':"{{$role->id}}"},
                            success: function (data) {
                                layer.msg('撤销权限成功');
                            },
                            error: function (xhr, status, error) {
                                layer.msg('撤销权限失败');
                                console.log(xhr);
                                console.log(status);
                                console.log(error);
                            }
                        });
                    }
                }
            });

            //监听提交
            form.on('submit(demo2)', function(data){
                /*     layer.alert(JSON.stringify(data.field), {
                 title: '最终的提交信息'
                 })*/
                return true;
            });

        });
    </script>
@endsection



