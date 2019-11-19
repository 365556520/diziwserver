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
            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="layadmin-user-login-box layadmin-user-login-header">
                    <h2>创建新账号</h2>
                    <p>用户不存在，请注册新账号</p>
                </div>
                <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
                    {{--图片--}}
                    <div class="layui-form-item">
                        <img src="{{$socialUser->avatar}}" class="layui-circle layui-nav-img"><span>{{$socialUser->nickname}}</span>
                    </div>
                    {{--隐藏表单第三方表单内容--}}
                    <input type="hidden" name="provider_id" value='{{$socialUser->id}}'>{{--第三方登录id--}}
                    <input type="hidden" name="provider" value='{{$socialUser->provider}}'>
                    <input type="hidden" name="headimg" value='{{$socialUser->avatar}}'>
                    {{--用户名--}}
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
                        <input type="text"  name="name" value="{{$socialUser->nickname}}"  placeholder="{{trans('auth/login.register.name')}}"   lay-verify="required"  class="layui-input">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <i class="layui-icon">&#xe69c;</i> {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>
                    {{--账号--}}
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-user" for="LAY-user-login-username"></label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" placeholder="{{trans('auth/login.register.username')}}"  lay-verify="required"  class="layui-input">
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <i class="layui-icon">&#xe69c;</i> {{ $errors->first('username') }}
                            </span>
                        @endif
                    </div>
                    {{--邮箱--}}
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-chat" for="LAY-user-login-username"></label>
                        <input id="email" type="email"  name="email" value="{{ old('email') }}"  placeholder="{{trans('auth/login.register.email')}}"  lay-verify="required"  class="layui-input">
                        @if ($errors->has('email'))
                            <span class="help-block">
                               <i class="layui-icon">&#xe69c;</i> {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                    {{--密码--}}
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                        <input  id="password" type="password"  name="password"  placeholder="{{trans('auth/login.register.password')}}" lay-verify="required"  class="layui-input">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <i class="layui-icon">&#xe69c;</i> {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                    {{--确认密码--}}
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                        <input  id="password-confirm" type="password"  placeholder="{{trans('auth/login.register.confirmPassword')}}"  name="password_confirmation" lay-verify="required"  class="layui-input">
                    </div>
                    {{--验证码--}}
                    <div class="layui-form-item">
                        <div class="layui-row">
                            <div class="layui-col-xs7">
                                <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>
                                <input type="text" id="captcha"   placeholder="{{trans('auth/login.captcha')}}"  name="captcha"  lay-verify="required"   class="layui-input">
                                @if ($errors->has('captcha'))
                                    <span class="help-block">
                                         <i class="layui-icon">&#xe69c;</i> {{ $errors->first('captcha') }}
                                    </span>
                                @endif
                            </div>
                            <div class="layui-col-xs5">
                                <div style="margin-left: 10px;">
                                    <img class="layadmin-user-login-codeimg" src="{{captcha_src('flat')}}" style="cursor: pointer;" onclick="this.src='{{captcha_src('flat')}}'+Math.random()">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <button class="layui-btn layui-btn-fluid " style="background-color:#ec706b;" lay-submit="" lay-filter="LAY-user-login-submit">注册新账户</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        //form提交
        layui.use('form', function(){
            var form = layui.form;
        });
    </script>
@endsection
