@extends('admin.layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
         @include('flash::message')
        <form class="layui-form layui-form-pane" lay-filter="add"  method="post" action="{{url('admin/buses')}}">
            {{csrf_field()}}
            <div class="layui-form-item">
                {{--车牌号--}}
                <div class="layui-inline">
                    <label class="layui-form-label" style=" padding: 9px 3px;">车牌号</label>
                    <div class="layui-input-block">
                        <input type="text" name="buses_name" lay-verify="required" placeholder="请输入车牌号" autocomplete="off" class="layui-input">
                    </div>
                </div>
                {{--车型--}}
                <div class="layui-inline">
                    <label class="layui-form-label">车型</label>
                    <div class="layui-input-block">
                        <input type="text" name="buses_type" lay-verify="required" placeholder="请输入车型" autocomplete="off" class="layui-input">
                    </div>
                </div>
                {{--核载--}}
                <div class="layui-inline">
                    <label class="layui-form-label">核载</label>
                    <div class="layui-input-block">
                        <input type="text" name="buses_sit" lay-verify="required|cate_view" placeholder="请输入核载人数" autocomplete="off" class="layui-input" style="width: 67%">
                    </div>
                </div>
            </div>
            <div  class="layui-form-item">
                {{--保险期限--}}
                <div class="layui-inline">
                    <label class="layui-form-label" style=" padding: 9px 3px;">保险期限</label>
                    <div class="layui-input-block">
                        <input type="text" name="buses_insurance_date" lay-verify="required"  placeholder="请输入保险期限" autocomplete="off" class="layui-input">
                    </div>
                </div>
                {{--保险期限--}}
                <div class="layui-inline">
                    <label class="layui-form-label" style="padding:9px 2px;">车辆审验时间</label>
                    <div class="layui-input-block">
                        <input type="text" name="buses_approve_date" lay-verify="required"  placeholder="请输入车辆审验时间" autocomplete="off" class="layui-input" >
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">发车时间</label>
                    <div class="layui-input-inline">
                        <input type="text" name="buses_start_date" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">返回时间</label>
                    <div class="layui-input-inline">
                        <input type="text" name="buses_end_date" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">往返时间填写格式例如时间多的用,号隔开（发车时间;6:20,12:10返回时间:9:10,5:20）</div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">车主</label>
                    <div class="layui-input-inline">
                        <input type="text" name="buses_boss" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">车主电话</label>
                    <div class="layui-input-inline" style="width:300px;">
                        <input type="text" name="buses_phone" lay-verify="required|phone" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">驾驶员</label>
                    <div class="layui-input-inline">
                        <select name="buses_driver_id" lay-verify="required" lay-search="">
                            <option value="">选择驾驶员</option>
                            @foreach($driver as $d)
                                <option value="{{$d->id}}">{{$d->driver_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">营运线路</label>
                <div class="layui-input-block">
                    <select name="busesroute_id" lay-verify="required" lay-search="">
                        <option value="">选择营运线路</option>
                        @foreach($busesRoute as $v)
                            <optgroup label="{{$v->buses_start}}-{{$v->buses_midway}}-{{$v->buses_end}}">
                                @foreach($v->children as $vl)
                                    <option value="{{$vl->id}}">{{$vl->buses_start}}-{{$vl->buses_midway}}-{{$vl->buses_end}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo2">添加班车</button>
            </div>
        </form>
    </div>
@endsection
@section('js')
   {{--查看本编辑中查看源码需要用到ace插件--}}
    <script src="{{asset('/backend/myvebdors/layui/ace/ace.js')}}"></script>
    <script>
        layui.use(['form', 'laydate', 'layer', 'jquery'], function(){
            var $ = layui.jquery
                ,form = layui.form
                ,laydate = layui.laydate
                , $ = layui.jquery;
            //自定义验证规则
            form.verify({
                cate_view: [/^[0-9]{1,7}$/, '必须数字但不能大于7位']
            });
            //监听提交
            form.on('submit(demo2)', function(data){
                /*     layer.alert(JSON.stringify(data.field), {
                 title: '最终的提交信息'
                 })*/
      /*          parent.layer.closeAll();*/
                return true;
            });

            //初始只
            form.val("add", {
                "view":0
            });

        });
    </script>
@endsection