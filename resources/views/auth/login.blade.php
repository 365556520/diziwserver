@extends('layouts.layuicontent')
@section('title')
    <title>{{trans('auth/login.title.admin')}}</title>
@endsection
@section('css')
    {{--注册页面css--}}
    <link href="{{ asset('mycss/Auth/login.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div>
        <div class="layadmin-user-login-main" style="margin-top: 30px">
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="layadmin-user-login-box layadmin-user-login-header">
                    <h2>{{trans('auth/login.title.admin')}}</h2>
                    <p>笛子网后台管理系统</p>
                </div>
                <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
                    {{--账号--}}
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
                        <input type="text" id="config('admin.globals.username')" placeholder="{{trans('auth/login.loginform.username')}}"  name="{{config('admin.globals.username')}}" value="{{ old(config('admin.globals.username')) }}" lay-verify="required"  class="layui-input">
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <i class="layui-icon">&#xe69c;</i> {{ $errors->first('username') }}
                            </span>
                        @endif
                    </div>
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                        <input type="password" name="password" id="password" lay-verify="required" placeholder="{{trans('auth/login.loginform.password')}}"  class="layui-input">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <i class="layui-icon">&#xe69c;</i> {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-row">
                            <div class="layui-col-xs7">
                                <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>
                                <input type="text" id="captcha" lay-verify="required"  placeholder="{{trans('auth/login.captcha')}}"  name="captcha" class="layui-input">
                                @if ($errors->has('captcha'))
                                    <span class="help-block">
                                        <i class="layui-icon">&#xe69c;</i> {{ $errors->first('captcha') }}
                                    </span>
                                @endif
                            </div>
                            <div class="layui-col-xs5">
                                <div style="margin-left: 10px;">
                                    <img class="layadmin-user-login-codeimg" src="{{captcha_src('math')}}" style="cursor: pointer;" onclick="this.src='{{captcha_src('math')}}'+Math.random()">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-bottom: 20px;">
                        <input type="checkbox"  name="remember"  {{ old('remember') ? 'checked' : '' }} lay-skin="primary" title="记住密码">
                        <div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>{{trans('auth/login.loginform.rememberPassword')}}</span><i class="layui-icon layui-icon-ok"></i></div>
                        <a href="javascript:;lostyourpassword()"  class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">{{trans('auth/login.loginform.Lost_your_password')}}</a>
                    </div>
                    <div class="layui-form-item">
                        <button class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="LAY-user-login-submit">{{trans('auth/login.loginform.submit')}}</button>
                    </div>
                    <div class="layui-trans layui-form-item layadmin-user-login-other">
                        <label>社交账号登入</label>
                        <a href="{{url('auth/qq')}}"><i class="layui-icon layui-icon-login-qq"></i></a>
                        <a href="{{url('auth/weibo')}}"><i class="layui-icon layui-icon-login-weibo"  style="color: #ff3a4d;"></i></a>
                        <a  href="javascript:;createAccount()" class="layadmin-user-jump-change layadmin-link">{!! trans('auth/login.loginform.createAccount') !!}</a>
                    </div>
                </div>
            </form>
        </div>
        测试
    </div>
@endsection
@section('js')
    <script>
        function lostyourpassword() {
            layer.open({
                type: 2,//2类型窗口 这里内容是一个网址
                title: '找回密码',
                shadeClose: true,
                shade: false,
                anim: 2, //打开动画
                maxmin: true, //开启最大化最小化按钮
                area: ['390px', '260px'],
                content: '{{url("/password/reset")}}',
            });
        }
        function createAccount() {
            layer.open({
                type: 2,//2类型窗口 这里内容是一个网址
                title: '注册账号',
                shadeClose: true,
                shade: false,
                anim: 2, //打开动画
                maxmin: true, //开启最大化最小化按钮
                area: ['60%', '95%'],
                content: '{{url("/register")}}',
            });
        }
        //form提交
        layui.use('form', function(){
            var form = layui.form;

        });

    </script>
@endsection
