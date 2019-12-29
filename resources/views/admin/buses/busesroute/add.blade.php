@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
    {{--inputTags 的css因为插件比较老有改动部分--}}
    <link href="{{ asset('/extend/layui/extend/inputTags/inputTags.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        <form class="layui-form " method="post" action="{{url('admin/busesroute')}}">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label class="layui-form-label">线路区域</label>
                <div class="layui-input-block">
                    <select name="buses_pid" lay-verify="" lay-search>
                        <option value="0">新增区域</option>
                        @foreach($busesroute as $v)
                            <option value="{{$v->id}}">{{$v->buses_start}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">起始地</label>
                <div class="layui-input-block">
                    <input type="text" name="buses_start" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">途经</label>
                <div class="layui-input-block tags" id="tags">
                    <input type="text"  id="inputTags" placeholder="回车生成地名" autocomplete="off">
                    <input type="text"  name="buses_midway" hidden>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">终点</label>
                <div class="layui-input-block">
                    <input type="text" name="buses_end" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo2">确认新建线路</button>
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

        layui.config({
            base: '/extend/layui/extend/inputTags/'//配置 layui 第三方扩展组件存放的基础目录
        }).extend({
            inputTags: 'inputTags' //定义该组件模块名
        }).use(['form', 'layer', 'inputTags'], function(){
            var form = layui.form
                ,layer = layui.layer
                ,inputTags = layui.inputTags;
            var buses_midway = [];
            inputTags.render({
                elem:'#inputTags',
                content: [],
                aldaBtn: true,
                done: function(value){
                    buses_midway.push(value);
                    $("[name='buses_midway']").val(JSON.stringify(buses_midway));
                    console.log(value)
                }
            });
            //监听提交
            form.on('submit(demo2)', function(data){
                /*layer.alert(JSON.stringify(data.field), {
                        title: '最终的提交信息'
                 });*/
                return true;
            });
        });
    </script>
@endsection
