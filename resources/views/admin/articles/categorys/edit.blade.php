@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        <form class="layui-form layui-form-pane" lay-filter="edit" method="post" action="{{url('admin/categorys/'.$categorysEdit->id)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <input type="hidden" value="{{$categorysEdit->id}}" name="id">
            <div class="layui-form-item">
                <label class="layui-form-label">分类标题</label>
                <div class="layui-input-inline">
                    <input type="text" name="cate_name" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">分类关系</label>
                    <div class="layui-input-inline">
                        <select name="cate_pid" lay-verify="" lay-search @if($categorysEdit->cate_pid == 0)disabled @endif>
                            <option value="0">顶级分类</option>
                            @foreach($categorys as $v)
                                <option value="{{$v->id}}" >{{$v->cate_name}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">浏览次数</label>
                <div class="layui-input-inline">
                    <input type="text" name="cate_view" lay-verify="cate_view" placeholder="请输入密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">必须填写数字但不能大于7位</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">分类关键词</label>
                <div class="layui-input-block">
                    <input type="text" name="cate_keywords" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">分类描述</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" name="cate_description" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo2">修改分类</button>
            </div>
        </form>
        @if(flash()->message)
            <div style="text-align:center;">
                <i class="layui-icon {{flash()->class}}">@if(flash()->class=='success')&#xe6af;@else&#xe69c;@endif {{flash()->message}}</i>
            </div>
        @endif
    </div>
@endsection
@section('js')
    <script>
        layui.use(['form', 'layedit', 'laydate'], function(){
            var form = layui.form
                ,layer = layui.layer
                ,layedit = layui.layedit;
            //自定义验证规则
            form.verify({
                cate_view: [/^[0-9]{1,7}$/, '必须数字但不能大于7位']

            });
            //初始值
            form.val("edit", {
                "cate_name": "{{$categorysEdit->cate_name}}"
                ,"cate_pid": "{{$categorysEdit->cate_pid}}"
                ,"cate_view": "{{$categorysEdit->cate_view}}"
                ,"cate_keywords": "{{$categorysEdit->cate_keywords}}"
                ,"cate_description": "{{$categorysEdit->cate_description}}"

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
