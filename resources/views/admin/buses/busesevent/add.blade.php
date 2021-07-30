@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
         <form class="layui-form layui-form-pane" method="post" action="{{url('admin/busesevent')}}">
            {{csrf_field()}}
             <div class="layui-row">
                    {{--车辆--}}
                    <div class="layui-col-xs12 layui-col-sm12 layui-col-md12">
                        <div class="layui-form-item">
                            <label class="layui-form-label">车辆id</label>
                            <div class="layui-input-block">
                                <input type="text" name="buses_id" lay-verify="required" placeholder="请输入车辆id" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    </div>

                 {{--添加时间--}}
                 <div class="layui-col-xs12 layui-col-sm12 layui-col-md12">
                     <div class="layui-form-item">
                         <label class="layui-form-label">事件时间</label>
                         <div class="layui-input-block">
                             <input type="text" name="event_time" lay-verify="required" placeholder="请输入事件时间" autocomplete="off" class="layui-input">
                         </div>
                     </div>
                 </div>

                    {{--事件内容--}}

                    <div class="layui-col-xs12 layui-col-sm12 layui-col-md12">
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">事件内容</label>
                            <div class="layui-input-block">
                                <textarea placeholder="请输入内容" name="content" class="layui-textarea"></textarea>
                            </div>
                        </div>
                    </div>

                    {{--上传图片--}}
                    <div class="layui-col-xs12 layui-col-sm12 layui-col-md12" >
                        <div class="layui-upload-drag" id="upload">
                            <div id="uptitle">
                                <i class="layui-icon"></i>
                                <p>上传照片</p>
                                <p>点击或将图片拖拽到此处</p>
                            </div>
                            <img class="layui-upload-img  img-responsive col-md-4 col-sm-4 col-xs-8 " alt="" id="demo1"/>
                            <input type="hidden" name="event_photo"  id="uploadimg" >
                        </div>
                    </div>
                </div>

             <div class="layui-form-item" STYLE="padding-top: 30px">
                 <button class="layui-btn" lay-submit="" lay-filter="demo2">添加事件</button>
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
                url: '/admin/driver/upload',
                data: {'_token':'{{csrf_token()}}'},
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
            //自定义验证规则
            form.verify({
                cate_view: [/^[0-9]{1,7}$/, '必须数字但不能大于7位']
            });
            //监听提交
            form.on('submit(demo2)', function(data){
                /*     layer.alert(JSON.stringify(data.field), {
                 title: '最终的提交信息'
                 })*/
                return true;
            });
        });

    </script>
@endsection
