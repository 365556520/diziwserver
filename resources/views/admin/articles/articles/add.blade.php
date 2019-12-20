@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <form class="layui-form layui-form-pane" lay-filter="add" method="post" action="{{url('admin/articles')}}">
            {{csrf_field()}}
            {{--作者id--}}
            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
            <div class="layui-collapse" >
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">文章信息</h2>
                    <div class="layui-colla-content layui-show">
                        <div class="layui-form-item">
                            <label class="layui-form-label">文章标题</label>
                            <div class="layui-input-inline">
                                <input type="text" name="title" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">文章分类</label>
                                <div class="layui-input-inline">
                                    <select name="category_id" lay-verify="required" lay-search="">
                                        <option value="">请选择</option>
                                        @foreach($categorys as $v)
                                            <optgroup label="{{$v->cate_name}}">
                                                @foreach($v->children as $vl)
                                                    <option value="{{$vl->id}}">{{$vl->cate_name}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">浏览次数</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="view"  lay-verify="" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item" pane="">
                            <label class="layui-form-label">文章级别</label>
                            <div class="layui-input-block">
                                <input type="radio" name="level" value=0 title="置顶" checked="">
                                <input type="radio" name="level" value=1 title="推荐">
                                <input type="radio" name="level" value=2 title="热门" >
                            </div>
                        </div>

                        <div class="layui-form-item" pane="">
                            <label class="layui-form-label">文章状态</label>
                            <div class="layui-input-block">
                                <input type="checkbox" value="1" name="state" lay-skin="switch" lay-filter="state" lay-text="通过|审核中">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">文章关键词</label>
                            <div class="layui-input-block">
                                <input type="text" name="tag" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">文章描述</label>
                            <div class="layui-input-block">
                                <textarea placeholder="请输入内容" name="description" class="layui-textarea"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">文章内容</h2>
                    <div class="layui-colla-content layui-show">
                        <div class="layui-form-item layui-form-text">
                            <div class="layui-input-block">
                              <textarea  name="content" id="content"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo2">发布文章</button>
            </div>
        </form>
        @if(flash()->message)
            <div style="text-align:center;">
                <i class="layui-icon {{flash()->class}}">@if(flash()->class=='success')&#xe6af;@else&#xe69c;@endif {{flash()->message}}</i>
            </div>
        @endif
    </div>
@endsection
@section('js')
   {{--加载富文本编辑器--}}
    <script src="{{asset('/extend/tinymce/tinymce.min.js')}}"></script>
    <script>
        //富文本编辑器配置
        tinymce.init({
            selector: '#content'
            ,height: 500
            ,language:'zh_CN'//注意大小写
            ,plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media code codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount imagetools textpattern help emoticons autosave bdmap indent2em autoresize lineheight formatpainter axupimgs',
            toolbar: 'code undo redo restoredraft | cut copy paste pastetext | forecolor backcolor bold italic underline strikethrough link anchor | alignleft aligncenter alignright alignjustify outdent indent | \
                        styleselect formatselect fontselect fontsizeselect | bullist numlist | blockquote subscript superscript removeformat | \
                        table   charmap emoticons hr pagebreak insertdatetime | fullscreen | bdmap indent2em lineheight formatpainter axupimgs',
            height: 650, //编辑器高度
            min_height: 400,
            /*content_css: [ //可设置编辑区内容展示的css，谨慎使用
                '/static/reset.css',
                '/static/ax.css',
                '/static/css.css',
            ],*/
            fontsize_formats: '12px 14px 16px 18px 24px 36px 48px 56px 72px',
            font_formats: '微软雅黑=Microsoft YaHei,Helvetica Neue,PingFang SC,sans-serif;苹果苹方=PingFang SC,Microsoft YaHei,sans-serif;宋体=simsun,serif;仿宋体=FangSong,serif;黑体=SimHei,sans-serif;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;',
            link_list: [
                { title: '预置链接1', value: 'http://www.tinymce.com' },
                { title: '预置链接2', value: 'http://tinymce.ax-z.cn' }
            ],
            image_list: [
                { title: '预置图片1', value: 'https://www.tiny.cloud/images/glyph-tinymce@2x.png' },
                { title: '预置图片2', value: 'https://www.baidu.com/img/bd_logo1.png' }
            ],
            image_class_list: [
                { title: 'None', value: '' },
                { title: 'Some class', value: 'class-name' }
            ],
            importcss_append: true,
            //自定义文件选择器的回调内容
            file_picker_callback: function (callback, value, meta) {
                if (meta.filetype === 'file') {
                    callback('https://www.baidu.com/img/bd_logo1.png', { text: 'My text' });
                }
                if (meta.filetype === 'image') {
                    callback('https://www.baidu.com/img/bd_logo1.png', { alt: 'My alt text' });
                }
                if (meta.filetype === 'media') {
                    callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.baidu.com/img/bd_logo1.png' });
                }
            },
            autosave_ask_before_unload: false,
        });
        layui.use(['form', 'layedit', 'laydate','element','layedit', 'layer', 'jquery'], function(){
            var $ = layui.jquery
                ,form = layui.form
                ,layer = layui.layer
                ,element = layui.element
                ,layedit = layui.layedit;
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
            //监听指定开关
            form.on('switch(state)', function(data){
                layer.tips('温馨提示：'+ (this.checked != 0 ? '直接通过审核！' : '不审核该文章！'), data.othis)
            });
            //初始只
            form.val("add", {
                "view":0
            });
            //富文本框
            layedit.set({
                //暴露layupload参数设置接口 --详细查看layupload参数说明
                uploadImage: {
                    url: '/admin/articles/upload',
                    accept: 'image',
                    acceptMime: 'image/*',
                    exts: 'jpg|png|gif|bmp|jpeg',
                    size: 1024 * 5,
                    done: function (data) {
                        if (data.code == 0){
                            layer.msg(data.msg, {
                                time: 1000, //1s后自动关闭
                            });
                        }
                    }
                }

                /*     // 需要在tool加入'video'
                 , uploadVideo: {
                 url: 'your url',
                 accept: 'video',
                 acceptMime: 'video/!*',
                 exts: 'mp4|flv|avi|rm|rmvb',
                 size: 1024 * 10 * 2,
                 done: function (data) {
                 console.log(data);
                 }
                 }
                 //需要在tool加入'attachment'
                 , uploadFiles: {
                 url: 'your url',
                 accept: 'file',
                 acceptMime: 'file/!*',
                 size: '20480',
                 done: function (data) {
                 console.log(data);
                 }
                 }*/
                //右键删除图片/视频时的回调参数，post到后台删除服务器文件等操作，
                //传递参数：
                //图片： imgpath --图片路径
                //视频： filepath --视频路径 imgpath --封面路径
                , calldel: {
                    url: '/admin/articles/calldel',
                    done: function (data) {
                        if (data.code == 0) {
                            layer.msg(data.msg, {
                                time: 1000, //1s后自动关闭
                            });
                        }else{
                            layer.msg(data.msg, {
                                time: 1000, //1s后自动关闭
                            });
                        }
                       // console.log(data);
                    }
                }
                //开发者模式 --默认为false
                , devmode: true
                //插入代码设置 --hide:true 等同于不配置codeConfig
                , codeConfig: {
                    hide: false,  //是否显示编码语言选择框
                    default: 'javascript' //hide为true时的默认语言格式
                }
                //新增iframe外置样式和js
                //, quote:{
                //    style: ['/Content/Layui-KnifeZ/css/layui.css','/others'],
                //    js: ['/Content/Layui-KnifeZ/lay/modules/jquery.js']
                //}
                //自定义样式-暂只支持video添加
                //, customTheme: {
                //    video: {
                //        title: ['原版', 'custom_1', 'custom_2']
                //        , content: ['', 'theme1', 'theme2']
                //        , preview: ['', '/images/prive.jpg', '/images/prive2.jpg']
                //    }
                //}
                //插入自定义链接
                , customlink:{
                    title: '插入layui官网'
                    ,href: ''
                    ,onmouseup:''
                }
                , facePath:'http://knifez.gitee.io/kz.layedit/Content/Layui-KnifeZ/' //这个是表情地址
                ,tool: [
                    'html'//源码模式
                    ,'undo','redo' //撤销重做--实验功能，不推荐使用
                    ,'code', 'strong', 'italic', 'underline', 'del'
                    ,'addhr' //添加水平线
                    ,'|', 'fontFomatt','fontfamily','fontSize' //段落格式，字体样式，字体颜色
                    , 'colorpicker', 'fontBackColor'//字体颜色,字体背景色
                    , 'face', '|', 'left', 'center', 'right', '|', 'link', 'unlink'
                    ,'images'//多图上传
                    , 'image_alt'//上传图片拓展
                    ,'anchors' //锚点
                    , '|', 'table'//插入表格
                    ,'customlink'//插入自定义链接
                    ,'fullScreen'//全屏
                    ,'preview'//预览
                ]
                , height: '90%'
            });
            var ieditor = layedit.build('content');
            //设置编辑器内容
            layedit.setContent(ieditor, '美好的一天，就这样开始了！ <img src="http://knifez.gitee.io/kz.layedit/Content/Layui-KnifeZ/images/face/1.gif" alt="[嘻嘻]">', false);

        });
    </script>
@endsection
