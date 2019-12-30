@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    {{--bootstrap-tagsinput 插件 输入框带标签--}}
    <link href="{{asset('extend/bootstrap-tagsinput-master/dist/bootstrap-tagsinput.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        <form class="layui-form " method="post" action="{{url('admin/busesroute')}}">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 90px;">线路分类</label>
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
                <div class="layui-inline">
                    <label class="layui-form-label">起点</label>
                    <div class="layui-input-inline">
                        <input type="text" name="buses_start" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                 </div>
                <div class="layui-inline">
                    <label class="layui-form-label">终点</label>
                    <div class="layui-input-inline">
                        <input type="text" name="buses_end" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 90px;">途经地点</label>
                <div class="layui-input-block" >
                    <input type="text" name="buses_midway" value=""  data-role="tagsinput"  >
                </div>
                <div class="layui-form-mid layui-word-aux">一个输入完成后回车生成地名。</div>
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

    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
    {{--bootstrap-tagsinput 插件 输入框带标签js--}}
    <script src="{{asset('extend/bootstrap-tagsinput-master/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script>
        layui.use(['form', 'layer'], function(){
            var form = layui.form
                ,layer = layui.layer;

            //监听提交
            form.on('submit(demo2)', function(data){
/*                layer.alert(JSON.stringify(data.field), {
                        title: '最终的提交信息'
                 });*/
                return true;
            });
        });
    </script>
@endsection
