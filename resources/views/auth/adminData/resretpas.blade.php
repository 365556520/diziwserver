@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')

@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        <div class="layui-card">
            <div class="layui-card-header">修改密码</div>
            <div class="layui-card-body">
                <form class="layui-form layui-form-pane" action="{{route('resetPas')}}" method="post">
                    {{csrf_field()}}
                    <div class="layui-form-item">
                        <label class="layui-form-label">旧密码</label>
                        <div class="layui-input-block">
                            <input type="text" name="original_password" lay-verify="required" placeholder="请输入原始密码"  autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">新密码</label>
                        <div class="layui-input-block">
                            <input type="text" name="password" lay-verify="required" placeholder="请输入新密码" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">确认密码</label>
                        <div class="layui-input-block">
                            <input type="text" name="password_confirmation" lay-verify="required" placeholder="请输入确认密码" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <button class="layui-btn" lay-submit=""  lay-filter="demo2">修改密码</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('js')

    <script>
        //form提交
        layui.use('form', function(){
            var form = layui.form;
            //监听提交
            form.on('submit(formDemo)', function(data){
            /*    layer.msg(JSON.stringify(data.field));*/
                return false;
            });
        });
    </script>


@endsection
