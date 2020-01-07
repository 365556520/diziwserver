@extends('layouts.layuicontent')
@section('title')
    <title>主页</title>
@endsection
@section('css')
    <link href="{{ asset('mycss/admincss/css/font_tnyc012u2rlwstt9.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('mycss/admincss/css/main.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('mycss/admincss/css/index.css')}}" rel="stylesheet" media="all">

@endsection
@section('content')
    <div class="layui-layout layui-layout-admin">
        <!-- 顶部 -->
        <div class="layui-header header">
            <div class="layui-main">
                <a href="index.html" class="logo" style="font-size:16px;font-weight:600;">LayuiCMSluyun</a>
                <!-- 显示/隐藏菜单 -->
                <a href="javascript:;" class="iconfont hideMenu icon-menu1"></a>
                <!-- 搜索 -->
                <div class="layui-form component">

                    <select name="modules" lay-verify="required" lay-search="" lay-filter="component">
                        <option value="">搜索组件或模块</option>
                        <option value="modules/code.html">code 代码修饰</option>
                    </select>

                    <i class="layui-icon" id="kscx">&#xe615;</i>
                </div>
                <!-- 顶部右侧菜单 -->
                <ul class="layui-nav top_menu">
                    <li class="layui-nav-item showNotice" id="showNotice" pc>
                        <a href="javascript:;"><i class="iconfont icon-gonggao"></i><cite>系统公告</cite></a>
                    </li>
                    <li class="layui-nav-item indexHelper" id="indexHelper" pc>
                        <a href="javascript:;" data-url="pages/helper/helper.html">
                            <i data-icon="&#xe607;"class="layui-icon">&#xe607;</i>
                            <cite>常见问题</cite>
                        </a>
                    </li>
                    <li class="layui-nav-item" mobile>
                        <a href="javascript:;" class="mobileAddTab" data-url="pages/user/userInfo.html">
                            <i class="iconfont icon-zhanghu" data-icon="icon-zhanghu"></i>
                            <cite>个人资料</cite>
                        </a>
                    </li>
               {{--     <dd><a href="javascript:;" href-url="{{route('showheadimg') }}"><i class="layui-icon">&#xe621;</i>修改图像</a></dd>
                    <dd><a href="javascript:;" href-url="{{route('resetPas')}}"><i class="layui-icon">&#xe621;</i>修改密码</a></dd>--}}
                    <li class="layui-nav-item" mobile>
                        <a href="login.html" class="signOut"><i class="iconfont icon-loginout"></i> 退出</a>
                    </li>
                    <li class="layui-nav-item lockcms" pc>
                        <a href="javascript:;"><i class="iconfont icon-lock1"></i><cite>锁屏</cite></a>
                    </li>
                    <li class="layui-nav-item" pc>
                        <a href="javascript:;">
                            <img src="{{Auth::user()->headimg}}" onerror="javascript:this.src='http://public.diziw.cn/diziw/images/default/default_zhaopian.jpg'"
                                 class="layui-circle userIconAs" width="35" height="35">
                            <cite class="userNameAs">{{Auth::user()->name}}</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd>
                                <a href="javascript:;" data-url="{{ url('/admin/home/'.Auth::user()->id.'/edit')}}">
                                    <i class="iconfont icon-zhanghu" data-icon="icon-zhanghu"></i>
                                    <cite>个人资料</cite>
                                </a>
                            </dd>
                            <dd>
                                <a href="javascript:;" data-url="{{route('resetPas')}}">
                                    <i class="iconfont icon-shezhi1" data-icon="icon-shezhi1"></i>
                                    <cite>修改密码</cite>
                                </a>
                            </dd>
                            <dd>
                                <a href="javascript:;" data-url="{{route('showheadimg')}}">
                                    <i class="layui-icon" data-icon="&#xe650;">&#xe650;</i>
                                    <cite>更换头像</cite>
                                </a>
                            </dd>
                            <dd>
                                <a href="javascript:;" class="changeSkin">
                                    <i class="iconfont icon-huanfu"></i>
                                    <cite>更换皮肤</cite>
                                </a>
                            </dd>
                            <dd>
                                <a href="javascript:;"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="signOut">
                                    <i class="iconfont icon-loginout"></i>
                                    <cite>安全退出</cite>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </a>
                            </dd>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 左侧导航 -->
        <div class="layui-side layui-bg-black">
           {{--  <div class="user-photo">
                <a class="img" title="我的头像"><img src="/images/face.jpg" class="userIconAs" ></a>
                <p>你好！<strong><span class="userName userNameAs">admin</span></strong>, 欢迎登录</p>
            </div>--}}
            <div class="navBar layui-side-scroll"></div>
        </div>
        <!-- 右侧内容 -->
        <div class="layui-body layui-form">
            <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
                <ul class="layui-tab-title top_tab" id="top_tabs">
                    <li class="layui-this" lay-id=""><i class="layui-icon">&#xe68e;</i> <cite>主页</cite></li>
                </ul>
                <ul class="layui-nav closeBox">
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="iconfont icon-caozuo"></i> 页面操作</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;" class="refresh refreshThis"><i class="layui-icon">&#xe669;</i>
                                    刷新当前</a></dd>
                            <dd><a href="javascript:;" class="closePageOther"><i class="iconfont icon-prohibit"></i>
                                    关闭其他</a></dd>
                            <dd><a href="javascript:;" class="closePageAll"><i class="iconfont icon-guanbi"></i>
                                    关闭全部</a></dd>
                        </dl>
                    </li>
                </ul>
                <div class="layui-tab-content clildFrame">
                    <div class="layui-tab-item layui-show">
                        <iframe src=""></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 移动导航 -->
    <div class="site-tree-mobile layui-hide"><i class="layui-icon">&#xe602;</i></div>
    <div class="site-mobile-shade"></div>
@endsection
@section('js')
    <script src="{{asset('myjs/adminjs/js/jquery.util.js')}}"></script>
    <script src="{{asset('myjs/adminjs/js/javascript.util.js')}}"></script>
    <script src="{{asset('myjs/adminjs/js/layui.util.js')}}"></script>
    <script src="{{asset('myjs/adminjs/js/index.js')}}"></script>
    <script>
        (function () {
            if (getIsWeb() === false) {
                alert('建议在web服务容器中打开此网页，如iis、Apache Tomcat、Nginx、node server等。当前状态下被限制了很多功能。');
            }

            pageKeepTop();
        }());

        $(function () {
            //可在这里加载用户信息
            console.log(",有什么建议或者bug,欢迎issues。", "color:red");

            layui.use('form', function () {
                layui.form.on('select(component)', function (data) {
                    //左上角下拉框
                    window.open('https://www.layui.com/doc/' + data.value);
                });
            });
        });
    </script>
@endsection
