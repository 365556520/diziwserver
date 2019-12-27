@extends('admin.layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/user.title')}}</title>
@endsection
@section('css')

@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        @include('flash::message')
        <form class="layui-form layui-form-pane " method="post" action="{{url('admin/driver/'.$driver->id)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <input type="hidden" value="{{$driver->id}}" name="id">
            <div class="layui-row">
                <div class="layui-col-xs12 layui-col-sm12 layui-col-md8">
                    <div class="layui-row">
                        {{--姓名--}}
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">姓名</label>
                                <div class="layui-input-block">
                                    <input type="text" name="driver_name" value="{{$driver->driver_name}}" lay-verify="required" placeholder="请输入驾驶员姓名" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        </div>
                        {{--电话--}}
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">联系电话</label>
                                <div class="layui-input-block">
                                    <input type="text" name="driver_phone" value="{{$driver->driver_phone}}"  lay-verify="required|phone|number" placeholder="请输入联系电话" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-row">
                        {{--年龄--}}
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">年龄</label>
                                <div class="layui-input-block">
                                    <input type="text" name="driver_age" value="{{$driver->driver_age}}"  lay-verify="required|number" placeholder="请输入年龄" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        </div>
                        {{--性别--}}
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">性别</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="driver_sex" value="男" title="男"  @if($driver->driver_sex == '男')checked=""@endif>
                                    <input type="radio" name="driver_sex" value="女" title="女"  @if($driver->driver_sex == '女')checked=""@endif>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-row">
                        {{--驾驶证号--}}
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">驾驶证号</label>
                                <div class="layui-input-block">
                                    <input type="text" name="driver_card" value="{{$driver->driver_card}}"  lay-verify="required|identity" placeholder="请输入驾驶证号" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        </div>
                        {{--初领日期--}}
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md6">
                            <div class="layui-form-item">
                                <label class="layui-form-label">初领日期</label>
                                <div class="layui-input-block">
                                    <input type="text" name="driver_card_firstdata" value="{{$driver->driver_card_firstdata}}"  lay-verify="required" placeholder="请输入初领日期" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-col-xs12 layui-col-sm12 layui-col-md4">
                    {{--上传图片--}}
                    <div class="layui-row" >
                        <div class="layui-col-xs12 layui-col-sm12 layui-col-md12" style="margin-left: 15% ;">
                            <div class="layui-upload-drag" style="border: 1px dashed #e2e2e2; padding: 2px; text-align: center;" id="upload">
                                <div id="uptitle" hidden>
                                    <i class="layui-icon"></i>
                                    <p>上传驾驶员头像</p>
                                    <p>点击或将图片拖拽到此处</p>
                                </div>
                                <img class="layui-upload-img  img-responsive col-md-4 col-sm-4 col-xs-8 " style="min-width: 150px;min-height: 150px;max-width: 150px;max-height: 150px"  @if(empty($driver->driver_photo)) src="{{url('/backend/images/default/default_zhaopian.jpg')}}"@else src={{url($driver->driver_photo)}}@endif  alt="" id="demo1"/>
                                <input type="hidden" value="{{$driver->driver_photo}}"  name="driver_photo"  id="uploadimg" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-row">
                <div class="layui-col-xs12 layui-col-sm12 layui-col-md4">
                    {{--驾驶证档案号--}}
                    <div class="layui-form-item">
                        <label class="layui-form-label" style=" padding: 9px 3px;">驾驶证档案号</label>
                        <div class="layui-input-block">
                            <input type="text" name="driver_archive_number" value="{{$driver->driver_archive_number}}"  lay-verify="required" placeholder="请输入证档案号" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-col-xs12 layui-col-sm12 layui-col-md3">
                    {{--准驾车型--}}
                    <div class="layui-form-item">
                        <label class="layui-form-label">准驾车型</label>
                        <div class="layui-input-block">
                            <input type="text" name="driver_permit" value="{{$driver->driver_permit}}"  lay-verify="required" placeholder="准驾车型" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-col-xs12 layui-col-sm12 layui-col-md5">
                    {{--驾驶证审验有效时间--}}
                    <div class="layui-form-item">
                        <label class="layui-form-label" style="width: 150px;padding:9px 2px;">驾驶证审验有效时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="driver_card_date" value="{{$driver->driver_card_date}}"  lay-verify="required" placeholder="请输入驾驶证审验有效时间" autocomplete="off" class="layui-input" style="width: 67%">
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-row">
                <div class="layui-col-xs12 layui-col-sm12 layui-col-md6">
                    {{--从业资格证号--}}
                    <div class="layui-form-item">
                        <label class="layui-form-label" style=" padding: 9px 3px;">从业资格证号</label>
                        <div class="layui-input-block">
                            <input type="text" name="driver_qualification" value="{{$driver->driver_qualification}}"  lay-verify="required" placeholder="请输入从业资格证号" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-col-xs12 layui-col-sm12 layui-col-md6">
                    {{--从业资格证号--}}
                    <div class="layui-form-item">
                        <label class="layui-form-label" style="width: 150px;padding:9px 2px;">资格证审验有效时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="driver_qualification_date" value="{{$driver->driver_qualification_date}}"  lay-verify="required" placeholder="请输入资格证审验有效时间" autocomplete="off" class="layui-input" style="width: 67%">
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-row">
                <div class="layui-col-xs12 layui-col-sm12 layui-col-md12">
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">驾驶信息</label>
                        <div class="layui-input-block">
                            <textarea placeholder="驾驶信息"  name="driver_info" class="layui-textarea">{{$driver->driver_info}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
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
                url: '{{url("admin/driver/upload")}}',
                data: {'_token':'{{csrf_token()}}','id':'{{$driver->id}}'},
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
    {{--提示代码--}}
    @include('component.errorsLayer')
@endsection
