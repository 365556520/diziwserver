@extends('layouts.layuicontent')
@section('title')
    <title>主页</title>
@endsection
@section('css')
    <link href="{{ asset('mycss/admincss/css/font_tnyc012u2rlwstt9.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('mycss/admincss/css/main.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('mycss/admincss/css/main.luyun.css')}}" rel="stylesheet" />
@endsection
@section('content')
    <div class="layui-fluid">

        <div class="layui-card">
            <div class="layui-card-header">快捷入口</div>
            <div class="layui-card-body">
                <div class="layui-row" id="shortcutEntry">

                    <div class="layui-col-xs6 layui-col-sm4 layui-col-md2 layui-col-lg2">
                        <a href="{{url('admin/menu')}}" title="栏目管理" class="featured-app"
                           data-icon="&#xe63f;" data-mid="ColumnManagement">
                            <div class="featured-app-logo-wrapper">
                                <i class="layui-icon featured-app-logo">&#xe63f;</i>
                            </div>
                            <div class="featured-app-name">栏目管理</div>
                        </a>
                    </div>

                    <div class="layui-col-xs6 layui-col-sm4 layui-col-md2 layui-col-lg2">
                        <a href="{{url('admin/articles')}}" title="文章管理" class="featured-app"
                           data-icon="&#xe638;" data-mid="ContentManagement">
                            <div class="featured-app-logo-wrapper">
                                <i class="layui-icon featured-app-logo">&#xe638;</i>
                            </div>
                            <div class="featured-app-name">文章管理</div>
                        </a>
                    </div>

                    <div class="layui-col-xs6 layui-col-sm4 layui-col-md2 layui-col-lg2">
                        <a href="{{url('log-viewer')}}" title="系统日志" class="featured-app"
                           data-icon="layui-icon-survey" data-mid="AdvertisingManagement">
                            <div class="featured-app-logo-wrapper">
                                <i class="layui-icon layui-icon-survey featured-app-logo"></i>
                            </div>
                            <div class="featured-app-name">系统日志</div>
                        </a>
                    </div>

                    <div class="layui-col-xs6 layui-col-sm4 layui-col-md2 layui-col-lg2">
                        <a href="{{url('admin/user')}}" title="用户管理" class="featured-app"
                           data-icon="&#xe612;" data-mid="UserManagement">
                            <div class="featured-app-logo-wrapper">
                                <i class="layui-icon featured-app-logo">&#xe612;</i>
                            </div>
                            <div class="featured-app-name">用户管理</div>
                        </a>
                    </div>

                    <div class="layui-col-xs6 layui-col-sm4 layui-col-md2 layui-col-lg2">
                        <a href="{{url('admin/permission')}}" title="权限设置" class="featured-app"
                           data-icon="&#xe60a;" data-mid="PermissionSettings">
                            <div class="featured-app-logo-wrapper">
                                <i class="layui-icon featured-app-logo">&#xe60a;</i>
                            </div>
                            <div class="featured-app-name">权限设置</div>
                        </a>
                    </div>

                    <div class="layui-col-xs6 layui-col-sm4 layui-col-md2 layui-col-lg2">
                        <a href="{{url('admin/role')}}" title="角色管理" class="featured-app"
                           data-icon="&#xe613;" data-mid="RoleManagement">
                            <div class="featured-app-logo-wrapper">
                                <i class="layui-icon featured-app-logo">&#xe613;</i>
                            </div>
                            <div class="featured-app-name">角色管理</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-row">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>待办事项</legend>
            </fieldset>
        </div>

        <div class="layui-row">
            <div id="main_Batch" class="panel_box" ashare-power-id="main_Batch">
                <div class="panel col">
                    <a href="javascript:;" data-url="../../page/main/Query.html" data-layid="aspdotnetcore">
                        <div class="panel_icon">
                            <i class="layui-icon" data-icon="&#xe64d;">&#xe64d;</i>
                        </div>
                        <div class="panel_word newMessage">
                            <span id="todo_ocrerr">*</span>
                            <cite>asp.net core</cite>
                        </div>
                    </a>
                </div>
                <div class="panel col">
                    <a href="javascript:;" data-url="../../page/main/Query.html" data-layid="kafka">
                        <div class="panel_icon" style="background-color: #FF5722;">
                            <i class="layui-icon" data-icon="&#x1006;">&#x1006;</i>
                        </div>
                        <div class="panel_word newMessage">
                            <span id="todo_conflict">*</span>
                            <cite>kafka</cite>
                        </div>
                    </a>
                </div>
                <div class="panel col">
                    <a href="javascript:;" data-url="../../page/main/Query.html" data-layid="Elasticsearch">
                        <div class="panel_icon" style="background-color: #009688;">
                            <i class="layui-icon" data-icon="&#x1007;">&#x1007;</i>
                        </div>
                        <div class="panel_word newMessage">
                            <span id="todo_checkerr">*</span>
                            <cite>Elasticsearch</cite>
                        </div>
                    </a>
                </div>
                <div class="panel col">
                    <a href="javascript:;" data-url="../../page/main/Query.html" data-layid="MongoDB">
                        <div class="panel_icon" style="background-color: #5FB878;">
                            <i class="layui-icon" data-icon="&#xe64f;">&#xe64f;</i>
                        </div>
                        <div class="panel_word newMessage">
                            <span id="todo_matcherr">*</span>
                            <cite>MongoDB</cite>
                        </div>
                    </a>
                </div>
                <div class="panel col">
                    <a href="javascript:;" data-url="../../page/main/Query.html" data-layid="Redis">
                        <div class="panel_icon" style="background-color: #F7B824;">
                            <i class="layui-icon" data-icon="&#xe857;">&#xe857;</i>
                        </div>
                        <div class="panel_word newMessage">
                            <span id="todo_posterr">*</span>
                            <cite>Redis</cite>
                        </div>
                    </a>
                </div>
                <div class="panel col">
                    <a href="javascript:;" data-url="../../page/main/Query.html" data-layid="Linux">
                        <div class="panel_icon" style="background-color: #2F4056;">
                            <i class="layui-icon" data-icon="&#xe60f;">&#xe60f;</i>
                        </div>
                        <div class="panel_word newMessage">
                            <span id="no_match_bill">*</span>
                            <cite>Linux</cite>
                        </div>
                    </a>
                </div>
                <div class="panel col">
                    <a href="javascript:;" data-url="../../page/main/Query.html" data-layid="Docker">
                        <div class="panel_icon" style="background-color:#FF3399;">
                            <i class="layui-icon" data-icon="&#xe63f;">&#xe63f;</i>
                        </div>
                        <div class="panel_word newMessage">
                            <span id="todo_comp_null">*</span>
                            <cite>Docker</cite>
                        </div>
                    </a>
                </div>
                <div class="panel col">
                    <a href="javascript:;" data-url="../../page/main/Query.html" data-layid="Gateway">
                        <div class="panel_icon" style="background-color: #990000;">
                            <i class="iconfont icon-text" data-icon="iconfont icon-text"></i>
                        </div>
                        <div class="panel_word newMessage">
                            <span id="todo_no_match">*</span>
                            <cite>Gateway</cite>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="layui-row">
            <hr>
        </div>

        <div class="layui-row">
            <div class="layui-col-xs12 layui-col-sm12 layui-col-md7  layui-col-lg7" style="padding-right: 2px">
                <blockquote style="font-size: 18px;" class="layui-elem-quote">用户访问来源</blockquote>

                <h3 style="text-align: center;">
                    <label class="layui-form-label">访问日期:</label>
                    <input type="text" style="width: 180px;" class="layui-input" id="scanDate">
                </h3>
                <br />
                <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
                <div id="main" style="width: 100%; height: 400px;"></div>
            </div>
            <div class="layui-col-xs12 layui-col-sm12 layui-col-md5 layui-col-lg5" style="padding-left: 2px">
                <blockquote style="margin-bottom:0px;" class="layui-elem-quote layui-quote-nm">用户访问来源数据表(点击饼图可显示对应的信息)
                </blockquote>

                <table id="scanTable" lay-filter="test"></table>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script src="{{asset('myjs/adminjs/js/jquery.util.js')}}"></script>
    <script src="{{asset('myjs/adminjs/js/javascript.util.js')}}"></script>
    <script src="{{asset('myjs/adminjs/js/layui.util.js')}}"></script>
    <script src="{{asset('myjs/adminjs/js/main.js')}}"></script>
    <script>

    </script>
@endsection
