@extends('layouts.layuicontent')
@section('title')
    <title>修改密码</title>
@endsection
@section('css')
    {{--注册页面css--}}
    <link href="{{ asset('mycss/Auth/login.css')}}" rel="stylesheet">
@endsection
@section('content')
<div>
    <div class="layadmin-user-login-main">
            <form class="form-horizontal" method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="layadmin-user-login-box layadmin-user-login-header">
                    <h2>修改密码</h2>
                </div>
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
                    {{--邮箱--}}
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-chat" for="LAY-user-login-username"></label>
                        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}"  placeholder="{{trans('auth/login.email.email')}}" lay-verify="required"  class="layui-input">
                        @error('email')
                             <span class="help-block">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    {{--密码--}}
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                        <input  id="password" type="password"  name="password"  placeholder="新密码" lay-verify="required"  class="layui-input">
                        @error('password')
                            <span class="help-block">
                                <i class="layui-icon">&#xe69c;</i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    {{--确认密码--}}
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                        <input  id="password-confirm" type="password"  placeholder="{{trans('auth/login.register.confirmPassword')}}"  name="password_confirmation" lay-verify="required"  class="layui-input">
                    </div>


                    <div class="layui-form-item">
                        <button class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="LAY-user-login-submit">修改密码</button>
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
