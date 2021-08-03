@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    {{--cropper-cs--}}
    <link  href="{{asset('/extend/cropper-master/dist/cropper.min.css')}}" rel="stylesheet">
    {{--剪切头像css--}}
    <style>
        #image {
            max-width: 100%;
        }
        .img-preview{
            width: 100px;
            height: 100px;
            overflow: hidden;
        }
        #result {
            width: 80px;
            height: 80px;
        }
        .img-container {
            margin-bottom: 1rem;
            max-height: 400px;
            min-height: 300px;
            max-width: 500px;
            min-width: 400px;
        }
        .img-Left{
            margin-left: 30px;
        }
    </style>

@endsection
@section('content')
    <div class="row" style="margin: 20px">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <label class="btn btn-danger" for="photoInput">
                        <input type="file" class="sr-only" id="photoInput" accept="image/*">
                        <span>打开图片</span>
                    </label>
                    <button class="btn btn-danger" id="rotate-Left" >右转45度</button>
                    <button class="btn btn-danger" id="rotate-Right" >左转45度</button>
                    <button class="btn btn-danger"  id="btnimg">裁剪预览</button>

                </div>
            </div>
            <br>
            {{--剪切图片核心--}}
            <div class="row">
                <div class="col-md-9 col-sm-12 col-xs-12 img-container" >
                    <img id="image" src="{{Auth::user()->headimg}}"  >
                </div>

                <div class="col-md-3 col-sm-12 col-xs-12 img-Left ">
                    <div class="row ">
                        <div class="col-md-12 col-sm-12 col-xs-12" >
                            <p>预览效果:</p>
                            {{--预览效果这里的div必须是这样的样式才能显示--}}
                            <div class="docs-preview clearfix ">
                                <div class="img-preview  preview-xs layui-circle"></div>
                            </div>
                            <P>x:<small id="imgdatax"></small> y:<small id="imgdatay"></small></P>
                            <P>宽度:<small id="imgdatawidth"></small>px</P>
                            <p>高度:<small id="imgdataheight"></small>px</P>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12 col-sm-12 col-xs-12" >
                            {{--预览效果end--}}
                            <p>裁剪结果:</p>
                            <img class="layui-circle" src="{{Auth::user()->headimg}}" id="result">
                            <br><br>
                            <button  class="btn btn-danger" id="submitbtn">上传图像</button>
                            <form id="submitForm" action="{{route('headimg')}}" method="get">
                                {{csrf_field()}}
                                <input type="hidden" name="user_data_img" id="user_data_img" value="{{Auth::user()->id}}"/>
                                <input type="hidden" name="headimg" id="headimg"/>
                            </form>
                        </div>
                    </div>
                </div>
                <br>

            </div>
            {{--剪切图片核心end--}}
        </div>
    </div>
@endsection
@section('js')

    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
    {{--cropperjs 剪切图片插件--}}
    <script src="{{asset('/extend/cropper-master/dist/cropper.js')}}"></script>
    <script src="{{ asset('/myjs/adminjs/js/home/headimg.js')}}"></script> {{--自己的js脚本--}}
    <script src="{{ asset('/myjs/adminjs/js/uuid.js')}}"></script> {{--自己的js脚本--}}

    <script>
        //            开始加载
        $(function () {
            headimg.init();
        });
    </script>
@endsection








