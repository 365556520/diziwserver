@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/user.title')}}</title>
@endsection
@section('css')
    {{--inputTags 的css因为插件比较老有改动部分--}}
    <link href="{{ asset('/extend/layui/extend/inputTags/inputTags.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        {{--添加班车线路--}}
         <form class="layui-form " method="post" lay-filter="edit" action="{{url('admin/busesroute/'.$busesroute->id)}}">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <input type="hidden" value="{{$busesroute->id}}" name="id">
                <div class="layui-form-item">
                    <label class="layui-form-label">线路类</label>
                    <div class="layui-input-block">
                        <select name="buses_pid" lay-verify="required" lay-search="" @if($busesroute->buses_pid == 0)disabled @endif>
                            <option value="0">线路分类</option>
                            @foreach($pid as $routes)
                                <option value="{{$routes->id}}">{{$routes->buses_start}}-{{$routes->buses_midway}}-{{$routes->buses_end}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">起点</label>
                    <div class="layui-input-block">
                        <input type="text" name="buses_start" value="{{$busesroute->buses_start}}" required="required" autocomplete="off" placeholder=""class="layui-input">
                    </div>
                </div>
                 <div class="layui-form-item">
                     <label class="layui-form-label">途经</label>
                     <div class="layui-input-block tags" id="tags">
                         <input type="text"  id="inputTags" placeholder="回车生成地名" autocomplete="off">
                         <input type="text"  name="buses_midway"  value="{{$busesroute->buses_midway}}" hidden>
                     </div>
                 </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">终点</label>
                    <div class="layui-input-block">
                        <input type="text" name="buses_end"  value="{{$busesroute->buses_end}}" required="required" autocomplete="off" placeholder=""class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn" lay-submit="" lay-filter="demo2" >修改班车线路</button>
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
        }).use(['form', 'layer','layedit', 'inputTags'], function(){
            var form = layui.form
                ,layer = layui.layer
                ,layedit = layui.layedit
                ,inputTags = layui.inputTags;

            let savrdata = '{{$busesroute->buses_midway}}';
            //因为服务器穿过来的json的"都变成&quot;因此用正则全部转义在转换成数组
            let data = JSON.parse(savrdata.replace(/&quot;/g,"\""));
            var buses_midway = data;
            inputTags.render({
                elem:'#inputTags',
                content:data,
                aldaBtn: false,
                done: function(value){
                    buses_midway.push(value);
                    console.log(buses_midway)
                    console.log(value)
                }
            });
            form.val("edit", {
                "buses_pid":"{{$busesroute->buses_pid}}"
            });
            //监听提交
            form.on('submit(demo2)', function(data){
                $("[name='buses_midway']").val(JSON.stringify(buses_midway));
               /* layer.alert(JSON.stringify(data.field), {
                    title: '最终的提交信息'
                });*/
                return true;
            });

        });
    </script>
@endsection
