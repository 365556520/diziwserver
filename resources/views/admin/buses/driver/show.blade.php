@extends('admin.layouts.layuicontent')
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
                <div class="layui-col-md8 layui-col-sm8 layui-col-xs8">
                    <div class="row">
                        <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >名字:{{$driver->driver_name}}
                        </div>
                        <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >年龄:{{$driver->driver_age}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >性别:{{$driver->driver_sex}}
                        </div>
                        <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >联系电话:{{$driver->driver_phone}}
                        </div>
                    </div>
                    <hr class="layui-bg-blue">
                    <div class="row">
                        <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >驾驶证号:{{$driver->driver_card}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >驾驶证档案号:{{$driver->driver_archive_number}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >准驾车型:{{$driver->driver_permit}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >初领日期:{{$driver->driver_card_firstdata}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >驾驶证审验有效时间:{{$driver->driver_card_date}}
                        </div>
                    </div>
                </div>
                <div  class="layui-col-md4 layui-col-sm4 layui-col-xs4">
                    <div class="xiangkuang"
                         @if(empty($driver->driver_photo))
                         style ="background:  url({{url('/backend/images/default/default_zhaopian.jpg')}});background-size:100% 100%;"
                         @else
                         style ="background: url({{url($driver->driver_photo)}});background-size:100% 100%;"
                            @endif >
                    </div>
                </div>
            </div>
            <hr class="layui-bg-orange">
            <div class="row">
                <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >从业资格证号:{{$driver->driver_qualification}}
                </div>
                <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >资格证审验有效时间:{{$driver->driver_qualification_date}}
                </div>
            </div>
            <div class="row">
                <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >
                    <hr class="layui-bg-green">
                    <h3 style="text-align: center">驾驶信息</h3>
                    {{$driver->driver_info}}
                </div>
            </div>
        </div>
@endsection
@section('js')

@endsection


