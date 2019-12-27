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
            <div class="layui-col-md4 layui-col-sm12 layui-col-xs12 " >
                车牌号:{{$buses->buses_name}}
            </div>
            <div class="layui-col-md4 layui-col-sm12 layui-col-xs12 " >
                车型:{{$buses->buses_type}}
            </div>
            <div class="layui-col-md4 layui-col-sm12 layui-col-xs12 " >
                核载:{{$buses->buses_sit}}人
            </div>
        </div>
        <div class="row">
            <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >
                车主:{{$buses->buses_boss}}
            </div>
            <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >
                车主电话:{{$buses->buses_phone}}
            </div>
        </div>
        <div class="row">
            <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >
                发车时间:{{$buses->buses_start_date}}
            </div>
            <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >
                返回时间:{{$buses->buses_end_date}}
            </div>
        </div>
        <div class="row">
            <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >
                车辆审验时间:{{$buses->buses_approve_date}}
            </div>
            <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >
                保险期限:{{$buses->buses_insurance_date}}
            </div>
        </div>
        <hr class="layui-bg-red">
        <h2 style="text-align: center">营运线路</h2>
        <hr class="layui-bg-red">
        <div class="row">
            <div class="layui-col-md4 layui-col-sm12 layui-col-xs12">
                始发地:{{$buses->getBusesRoute->buses_start}}
            </div>
            <div class="layui-col-md4 layui-col-sm12 layui-col-xs12">
                途经:{{$buses->getBusesRoute->buses_midway}}
            </div>
            <div class="layui-col-md4 layui-col-sm12 layui-col-xs12">
                终点:{{$buses->getBusesRoute->buses_end}}
            </div>
        </div>
        <hr class="layui-bg-red">
        <h2 style="text-align: center">驾驶员信息</h2>
        <hr class="layui-bg-red">
        <div class="row">
            <div class="layui-col-md8 layui-col-sm12 layui-col-xs12">
                <div class="row">
                    <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >名字:{{$buses->getDriver->driver_name}}
                    </div>
                    <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >年龄:{{$buses->getDriver->driver_age}}
                    </div>
                </div>
                <div class="row">
                    <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >性别:{{$buses->getDriver->driver_sex}}
                    </div>
                    <div class="layui-col-md6 layui-col-sm12 layui-col-xs12 " >联系电话:{{$buses->getDriver->driver_phone}}
                    </div>
                </div>
                <hr class="layui-bg-blue">
                <div class="row">
                    <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >驾驶证号:{{$buses->getDriver->driver_card}}
                    </div>
                </div>
                <div class="row">
                    <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >驾驶证档案号:{{$buses->getDriver->driver_archive_number}}
                    </div>
                </div>
                <div class="row">
                    <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >准驾车型:{{$buses->getDriver->driver_permit}}
                    </div>
                </div>
                <div class="row">
                    <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >初领日期:{{$buses->getDriver->driver_card_firstdata}}
                    </div>
                </div>
                <div class="row">
                    <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >驾驶证审验有效时间:{{$buses->getDriver->driver_card_date}}
                    </div>
                </div>
            </div>
            <div  class="layui-col-md4 layui-col-sm12 layui-col-xs12">
                <div class="xiangkuang"
                     @if(empty($buses->getDriver->driver_photo))
                     style ="background:  url({{url('/backend/images/default/default_zhaopian.jpg')}});background-size:100% 100%;"
                     @else
                     style ="background: url({{url($buses->getDriver->driver_photo)}});background-size:100% 100%;"
                        @endif >
                </div>
            </div>
        </div>
        <hr class="layui-bg-blue">
        <div class="row">
            <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >从业资格证号:{{$buses->getDriver->driver_qualification}}
            </div>
            <div class="layui-col-md12 layui-col-sm12 layui-col-xs12 " >资格证审验有效时间:{{$buses->getDriver->driver_qualification_date}}
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
