@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        <div class="layui-card">
            <div class="layui-card-header">个人资料</div>
                <div class="layui-card-body">
                    <form class="layui-form layui-form-pane"  lay-filter="formdata"  action="{{url('admin/home',[Auth::user()->getUserData->id])}}" method="post">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        {{--       防止用户恶意修改表单id，如果id不一致直接跳转500--}}
                        <input type="hidden" name="id" value="{{Auth::user()->getUserData->id}}">
                        <div class="layui-form-item">
                            <label class="layui-form-label">昵称</label>
                            <div class="layui-input-inline">
                                <input type="text" name="nickname" lay-verify="required" placeholder="请输入"  autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">年龄</label>
                            <div class="layui-input-inline">
                                <input type="text" name="age" lay-verify="required" placeholder="请输入"  autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item" pane="">
                            <label class="layui-form-label">性别</label>
                            <div class="layui-input-block">
                                <input type="radio" name="sex" value=1 title="男" >
                                <input type="radio" name="sex" value=0 title="女" >
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">验证手机</label>
                            <div class="layui-input-block">
                                <input type="tel" name="ipone" lay-verify="required|phone"   placeholder="请输入手机号" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">QQ</label>
                            <div class="layui-input-block">
                                <input type="text" name="qq" lay-verify="title" autocomplete="off"   placeholder="请输入QQ号码" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">联系地址</label>
                            <div class="layui-input-block">
                                <input type="text" name="address"  placeholder="请输入联系地址" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">爱好</label>
                            <div class="layui-input-block">
                                <input type="text" name="hobby"  placeholder="请输入联系地址"  autocomplete="off" class="layui-input">
                            </div>
                        </div>


                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">个性签名</label>
                            <div class="layui-input-block">
                                <textarea placeholder="请输入内容" name="Readme" class="layui-textarea"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn" lay-submit=""  lay-filter="demo2">修改信息</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        layui.use(['form', 'layer'], function(){
            var form = layui.form
                ,layer = layui.layer;
            //表单赋值

            form.val('formdata', {
                "nickname": "{{Auth::user()->getUserData->nickname}}" // "name": "value"
                ,'age':"{{Auth::user()->getUserData->age}}"
                ,"sex": "{{Auth::user()->getUserData->sex}}"
                ,"ipone": "{{Auth::user()->getUserData->ipone}}"
                ,"qq": "{{Auth::user()->getUserData->qq}}"
                ,"address": "{{Auth::user()->getUserData->address}}"
                ,"hobby": "{{Auth::user()->getUserData->hobby}}"
                ,"Readme": "{{Auth::user()->getUserData->Readme}}"
            });
            //监听提交
            form.on('submit(demo1)', function(data){
/*                layer.alert(JSON.stringify(data.field), {
                    title: '最终的提交信息'
                })*/
                return false;
            });

        });
    </script>
@endsection
