@extends('layouts.layuicontent')
@section('title')
    <title>{{trans('auth/login.email.title')}}</title>
@endsection
@section('css')
    {{--注册页面css--}}
    <link href="{{ asset('mycss/Auth/login.css')}}" rel="stylesheet">

@endsection

@section('content')
    <div>
        <div class="layadmin-user-login-main">
           @if (session('status'))
                <div  style="font-size: 30px">
                    <i class="layui-icon layui-icon-face-smile" style="font-size: 30px; color: #1E9FFF;"> {{session('status')}}</i>
                </div>
            @else
                <form class="form-horizontal" method="POST"action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <div class="layadmin-user-login-box layadmin-user-login-header">
                        <h2></h2>
                    </div>
                    <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
                        {{--邮箱--}}
                        <div class="layui-form-item">
                            <label class="layadmin-user-login-icon layui-icon layui-icon-chat" for="LAY-user-login-username"></label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"  placeholder="{{trans('auth/login.email.email')}}" lay-verify="required"  class="layui-input">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                {{ $errors->first('email') }}
                            </span>
                            @endif
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="LAY-user-login-submit">{{trans('auth/login.email.submit')}}</button>
                        </div>
                    </div>
                </form>
            @endif
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








