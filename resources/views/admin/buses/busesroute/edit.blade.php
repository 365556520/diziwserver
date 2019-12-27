@extends('admin.layouts.bootstrapcontent')
@section('title')
    <title>{{ trans('admin/user.title')}}</title>
@endsection
@section('css')
    {{--layui-v2.2.5--}}
    <link href="{{ asset('/backend/myvebdors/layui-v2.2.5/layui/css/layui.css')}}" rel="stylesheet">
    {{--datatables 插件--}}
    <link href="{{asset('backend/vendors/DataTables-1.10.15/media/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    {{--bootstrap-tagsinput 插件 输入框带标签--}}
    <link href="{{asset('backend/myvebdors/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css')}}" rel="stylesheet">
    <!--或者下载到本地，下面有下载地址-->
@endsection
@section('content')
    <div class="">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>班车线路<small>班车线路管理页面</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                            <ul class="layui-tab-title">
                                <li><a href="{{ url('/admin/busesroute')}}">班车线路列表</a></li>
                                <li  class="layui-this">修改班车线路</li>
                            </ul>
                            {{--班车线路列表--}}
                            <div class="layui-tab-content" >
                                @include('flash::message')
                                <div class="layui-tab-item">
                                </div>
                                {{--添加班车线路--}}
                                <div class="layui-tab-item layui-show">
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
                                            <div class="layui-input-block">
                                                <input type="text" name="buses_midway" value="{{$busesroute->buses_midway}}" data-role="tagsinput" >
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">终点</label>
                                            <div class="layui-input-block">
                                                <input type="text" name="buses_end"  value="{{$busesroute->buses_end}}" required="required" autocomplete="off" placeholder=""class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <button class="layui-btn" lay-submit="" lay-filter="demo2">修改班车线路</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
@section('js')
    {{--layui-v2.2.5--}}
    <script src="{{asset('/backend/myvebdors/layui-v2.2.5/layui/layui.js')}}"></script>
    {{--datatables 插件--}}
    <script src="{{asset('backend/vendors/DataTables-1.10.15/media/js/jquery.dataTables.min.js')}}"></script>
    {{--bootstrap-tagsinput 插件 输入框带标签js--}}
    <script src="{{asset('backend/myvebdors/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.min.js')}}"></script>
    {{--导入自己js--}}
    <script src="{{asset('backend/js/buses/busesroute-list.js')}}"></script>
    <script>
        $(function () {
            busesrouteList.init();
        });
        layui.use(['form','element'], function(){
            var $ = layui.jquery
                ,form = layui.form
                ,element = layui.element; //Tab的切换功能，切换事件监听等，需要依赖element模块
            //表单初始值
            form.val("edit", {
                "buses_pid":"{{$busesroute->buses_pid}}"
            });
        });


    </script>
    {{--提示代码--}}
    @include('component.errorsLayer')
@endsection
