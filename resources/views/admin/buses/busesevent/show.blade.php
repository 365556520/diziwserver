@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
    <style>
        .xiangkuang{
            min-width: 130px;
            min-height: 150px;
            max-width: 130px;
            max-height: 150px;
            border:1px solid #000000;
            padding: 1px;
        }

    </style>
@endsection
@section('content')
        <div style="padding: 10px;">
            <div class="row">
                <div class="layui-col-md12 layui-col-sm12 layui-col-xs12">
                    <div class="row">
                        <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >车辆id:{{$busesevent->buses_id}}
                        </div>
                        <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >事件时间:{{$busesevent->event_time}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >车辆内容:{{$busesevent->content}}
                        </div>
                    </div>

                    <div  class="layui-col-md12 layui-col-sm12 layui-col-xs12">
                        <div class="xiangkuang"
                             @if(empty($busesevent->event_photo))
                             style ="background:  url('http://public.diziw.cn/diziw/images/default/default_zhaopian.jpg');background-size:100% 100%;"
                             @else
                             style ="background: url({{url($busesevent->event_photo)}});background-size:100% 100%;"
                            @endif >
                        </div>
                    </div>
                </div>

            </div>

        </div>
@endsection
@section('js')

@endsection


