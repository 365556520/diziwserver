@extends('layouts.layuicontent')
@section('title')

@endsection
@section('css')
  <style>
      .contrs{
          margin-top: 40px;
      }
      .cont{
          text-align: center;
          font-size: 40px;
          color: #1E9FFF;
      }
  </style>
@endsection
@section('content')
    <div class="contrs">
        <div class="layui-row">
            <div class="layui-col-sm12">
                <div class="cont"><i class="layui-icon layui-icon-face-smile" style="font-size: 80px;color: #1E9FFF;"></i>  </div>
                <div class="cont">{{$massage}}</div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection




