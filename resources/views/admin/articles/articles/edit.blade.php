@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <form class="layui-form layui-form-pane" lay-filter="edit" method="post" action="{{url('admin/articles/'.$articlesEdit->id)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <input type="hidden" value="{{$articlesEdit->id}}" name="id">
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
                                    <input type="text" name="view"  lay-verify="" autocomplete="off" class="layui-input" >
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
                                <textarea  name="content" id="content">
                                    {!! $articlesEdit->content !!}
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo2">确认修改</button>
            </div>
        </form>
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
            ,plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media code codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount imagetools textpattern help emoticons autosave  autoresize   ',
            toolbar: 'code undo redo restoredraft | cut copy paste pastetext | forecolor backcolor bold italic underline strikethrough link anchor | alignleft aligncenter alignright alignjustify outdent indent | \
                        styleselect formatselect fontselect fontsizeselect | bullist numlist | blockquote subscript superscript removeformat | \
                        table   charmap emoticons hr pagebreak insertdatetime | fullscreen   ',
            height: 650, //编辑器高度
            min_height: 400,
            fontsize_formats: '12px 14px 16px 18px 24px 36px 48px 56px 72px',
            font_formats: '微软雅黑=Microsoft YaHei,Helvetica Neue,PingFang SC,sans-serif;苹果苹方=PingFang SC,Microsoft YaHei,sans-serif;宋体=simsun,serif;仿宋体=FangSong,serif;黑体=SimHei,sans-serif;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;',
            link_list: [
                { title: '链接例子1', value: 'http://www.tinymce.com' },
                { title: '链接例子2', value: 'http://tinymce.ax-z.cn' }
            ],
            image_list: [
                { title: '图片例子1', value: 'https://www.tiny.cloud/images/glyph-tinymce@2x.png' },
                { title: '图片例子2', value: 'https://www.baidu.com/img/bd_logo1.png' }
            ],
            image_class_list: [
                { title: 'None', value: '' },
                { title: 'Some class', value: 'class-name' }
            ],
            image_caption: true, //图片标题
            image_advtab: true, //开启图片css样式
            importcss_append: true,
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
                return true;
            });
            //监听指定开关
            form.on('switch(state)', function(data){
                layer.tips('温馨提示：'+ (this.checked != 0 ? '直接通过审核！' : '不审核该文章！'), data.othis)
            });
            //表单初始值
            form.val("edit", {
                "title": '{{$articlesEdit->title}}',
                'category_id': '{{$articlesEdit->category_id}}',
                'thumb': '{{$articlesEdit->thumb}}',
                "view":'{{$articlesEdit->category_id}}',
                "level":'{{$articlesEdit->level}}',
                "state": '{{$articlesEdit->state}}'==1 ? true : false,
                "tag": '{{$articlesEdit->tag}}',
                "description": '{{$articlesEdit->description}}',
            });


        });
    </script>
@endsection
