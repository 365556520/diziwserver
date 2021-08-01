@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/user.title')}}</title>
@endsection
@section('css')

@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        <form class="layui-form layui-form-pane " method="post" action="{{url('admin/busesevent/'.$busesevent->id)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <input type="hidden" value="{{$busesevent->id}}" name="id">
            <div class="layui-row">

                <div class="layui-row">
                    {{--车辆id--}}
                    <div class="layui-col-xs12 layui-col-sm12 layui-col-md12">
                        <div class="layui-form-item">
                            <label class="layui-form-label">车辆id</label>
                            <div class="layui-input-block">
                                <input type="text" name="buses_id" value="{{$busesevent->buses_id}}" lay-verify="required" placeholder="请输入驾驶员姓名" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    </div>
                </div>

                {{--添加时间--}}

                <div class="layui-col-xs12 layui-col-sm12 layui-col-md12">
                    <div class="layui-form-item">
                        <label class="layui-form-label">事件时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="event_time"  value="{{$busesevent->event_time}}"    lay-verify="required" placeholder="请输入事件时间" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>

                {{--事件内容--}}

                <div class="layui-col-xs12 layui-col-sm12 layui-col-md12">
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">事件内容</label>
                        <div class="layui-input-block">
                            <textarea placeholder="请输入内容" name="content" class="layui-textarea">{{$busesevent->content}}</textarea>
                        </div>
                    </div>
                </div>

            {{--上传图片--}}

                <div class="layui-col-xs12 layui-col-sm12 layui-col-md12">
                    <div class="layui-upload-drag" style="border: 1px dashed #e2e2e2; padding: 2px; text-align: center;" id="upload">
                        <div id="uptitle" hidden>
                            <i class="layui-icon"></i>
                            <p>上传驾驶员头像</p>
                            <p>点击或将图片拖拽到此处</p>
                        </div>
                        <img class="layui-upload-img  img-responsive col-md-4 col-sm-4 col-xs-8 " style="min-width: 150px;min-height: 150px;max-width: 150px;max-height: 150px"  @if(empty($busesevent->event_photo)) src="{{url('/backend/images/default/default_zhaopian.jpg')}}"@else src={{url($busesevent->event_photo)}}@endif  alt="" id="demo1"/>
                        <input type="hidden" value="{{$busesevent->event_photo}}"  name="event_photo"  id="uploadimg" >
                    </div>
                </div>

            </div>


            <div class="layui-form-item" style="padding-top: 30px">
                <button class="layui-btn" lay-submit="" lay-filter="demo2">修改驾驶员</button>
            </div>
        </form>
    </div>
@endsection
@section('js')

    <script>
        layui.use(['element','upload','form'],function(){
            var $ = layui.jquery,
                form = layui.form,
                element = layui.element,//Tab的切换功能，切换事件监听等，需要依赖element模块
                upload = layui.upload;
            //拖拽上传
            upload.render({
                elem: '#upload',
                url: '{{url("admin/busesevent/upload")}}',
                data: {'_token':'{{csrf_token()}}','id':'{{$busesevent->id}}'},
                before: function(obj){
                    layer.load(); //上传loading
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#uptitle').hide();
                        $('#demo1').attr('src', result); //图片链接（base64）
                    });
                },
                done: function(res){
                    layer.closeAll('loading'); //关闭loading
                    //status=0代表上传成功
                    if(res.status == 0){
                        $('#uploadimg').attr('value',res.path); //把连接放到隐藏输入框中
                        $('#demo1').attr('value',res.path); //把连接放到隐藏输入框中
                        layer.msg(res.message, {icon: 6});   //do something （比如将res返回的图片链接保存到表单的隐藏域）
                    }else {
                        layer.msg(res.message, {icon: 5});
                    }
                },
                error: function(index, upload){
                    layer.closeAll('loading'); //关闭loading
                }
            });
        });
    </script>

@endsection
