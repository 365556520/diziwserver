@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/user.title')}}</title>
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
        {{--添加班车线路--}}
         <form class="layui-form " method="post" lay-filter="edit" action="{{url('admin/busesroute/'.$busesroute->id)}}">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <input type="hidden" value="{{$busesroute->id}}" name="id">
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 90px;">线路分类</label>
                    <div class="layui-input-inline">
                        <select name="buses_pid" lay-verify="required" lay-search="" @if($busesroute->buses_pid == 0)disabled @endif>

                            <option value="0">线路分类</option>
                            @foreach($pid as $routes)
                                <option value="{{$routes->id}}">{{$routes->buses_start}}-{{$routes->buses_midway}}-{{$routes->buses_end}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="layui-form-mid layui-word-aux">顶级线路不能更换！</div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">起点</label>
                        <div class="layui-input-inline">
                            <input type="text" name="buses_start" value="{{$busesroute->buses_start}}" required="required" autocomplete="off" placeholder=""class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">终点</label>
                        <div class="layui-input-inline">
                            <input type="text" name="buses_end"  value="{{$busesroute->buses_end}}" required="required" autocomplete="off" placeholder=""class="layui-input">
                        </div>
                    </div>
                </div>
                 <div class="layui-form-item">
                     <label class="layui-form-label" style="width: 90px;">途经地点</label>
                     <div class="layui-input-block">
                         {{--tagsinput 赋值的格式中间，隔开所以把字符串的引号和[]都去掉--}}
                         <input type="text" name="buses_midway" value="{{str_replace('"','', ltrim(rtrim($busesroute->buses_midway, "]"),'['))}}" data-role="tagsinput" >
                     </div>
                     <div class="layui-form-mid layui-word-aux">一个输入完成后回车生成地名。</div>
                 </div>

             <div class="layui-form-item">
                    <button class="layui-btn" lay-submit="" lay-filter="demo2" >修改班车线路</button>
                </div>
            </form>
    </div>
@endsection
@section('js')
    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
    {{--bootstrap-tagsinput 插件 输入框带标签js--}}
    <script src="{{asset('extend/bootstrap-tagsinput-master/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script>

        layui.use(['form', 'layer','layedit'], function(){
            var form = layui.form
                ,layer = layui.layer
                ,layedit = layui.layedit;
            form.val("edit", {
                "buses_pid":"{{$busesroute->buses_pid}}"
            });
            //监听提交
            form.on('submit(demo2)', function(data){
               /* layer.alert(JSON.stringify(data.field), {
                    title: '最终的提交信息'
                });*/
                return true;
            });

        });
    </script>
@endsection
