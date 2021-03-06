@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')

    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        <form class="layui-form layui-form-pane" lay-filter="edit" method="post" action="{{url('admin/goodscategorys/'.$gcEdit->id)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <input type="hidden" value="{{$gcEdit->id}}" name="id">
            <div class="layui-form-item">
                <label class="layui-form-label">商品分类名</label>
                <div class="layui-input-inline">
                    <input type="text" name="goodscategorys_name" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">分类关系</label>
                <div class="layui-input-inline">
                    <select name="goodscategorys_pid" lay-verify="" lay-search>
                        <option value="0">顶级分类</option>
                        @foreach($categorys as $v)
                            <option value="{{$v->id}}">{{$v->goodscategorys_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo2">确认修改</button>
            </div>
        </form>

    </div>

@endsection
@section('js')
    <script>
        layui.use(['form', 'layedit', 'laydate'], function(){
            var form = layui.form
                ,layer = layui.layer
            //自定义验证规则
            form.verify({
                cate_view: [/^[0-9]{1,7}$/, '必须数字但不能大于7位']

            });
            //初始值
            form.val("edit", {
                "goodscategorys_name": "{{$gcEdit->goodscategorys_name}}"
                ,"goodscategorys_pid": "{{$gcEdit->goodscategorys_pid}}"
            })
            //监听提交
            form.on('submit(demo2)', function(data){
       /*         layer.alert(JSON.stringify(data.field), {
                    title: '最终的提交信息'
                })*/
                return true;
            });


        });
    </script>
@endsection
