<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        {{--主用layui--}}
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('title')
        {{--layui--}}
        <link href="{{ asset('extend/layui/css/layui.css')}}" rel="stylesheet">
        @yield('css')
        <style>
            .success{
                color: #5ccb22;
                font-size:28px;
            }
            .flasherror{
                font-size:28px;
                color: #cb0322;
            }
            .error{
                color: #cb0322;
            }
        </style>
    </head>
    <body class="layui-bg-gray">
         @yield('content')
        {{--操作按钮--}}
        <script type="text/html" id="barDemo">
            <div class="layui-btn-group">
                <button class="layui-btn layui-btn-normal layui-btn-xs" lay-event="show"><i class="layui-icon">&#xe705;</i></button>
                <button class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i></button>
                <button class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon">&#xe640;</i></button>
            </div>
        </script>
        <!-- jQuery -->
        <script src="{{asset('extend/jq/jquery.min.js')}}"></script>
        {{--vue js--}}
    {{--    <script src="{{asset('extend/vue/vue.js')}}"></script>--}}
        <script src="{{asset('extend/layui/layui.js')}}"></script>
        <script>
            $(function() {
                //公共--自动为ajax请求自动添加csrf-token
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
        </script>
        @yield('js')
    </body>
</html>
