@extends('admin.layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/user.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="row" style="padding: 2px 15px 2px 15px">
        <form class="layui-form layui-form-pane " lay-filter="edit" method="post" action="{{url('admin/buses/'.$buses->id)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <input type="hidden" value="{{$buses->id}}" name="id">

            <div class="layui-form-item">
                {{--车牌号--}}
                <div class="layui-inline">
                    <label class="layui-form-label" style=" padding: 9px 3px;">车牌号</label>
                    <div class="layui-input-block">
                        <input type="text" name="buses_name" value="{{$buses->buses_name}}" lay-verify="required" placeholder="请输入车牌号" autocomplete="off" class="layui-input">
                    </div>
                </div>
                {{--车型--}}
                <div class="layui-inline">
                    <label class="layui-form-label">车型</label>
                    <div class="layui-input-block">
                        <input type="text" name="buses_type" value="{{$buses->buses_type}}"   lay-verify="required" placeholder="请输入车型" autocomplete="off" class="layui-input">
                    </div>
                </div>
                {{--核载--}}
                <div class="layui-inline">
                    <label class="layui-form-label">核载</label>
                    <div class="layui-input-block">
                        <input type="text" name="buses_sit" value="{{$buses->buses_sit}}" lay-verify="required" placeholder="请输入核载人数" autocomplete="off" class="layui-input" style="width: 67%">
                    </div>
                </div>
            </div>
            <div  class="layui-form-item">
                {{--保险期限--}}
                <div class="layui-inline">
                    <label class="layui-form-label" style=" padding: 9px 3px;">保险期限</label>
                    <div class="layui-input-block">
                        <input type="text" name="buses_insurance_date" value="{{$buses->buses_insurance_date}}" lay-verify="required"  placeholder="请输入保险期限" autocomplete="off" class="layui-input">
                    </div>
                </div>
                {{--车辆审验时间--}}
                <div class="layui-inline">
                    <label class="layui-form-label" style="padding:9px 2px;">车辆审验时间</label>
                    <div class="layui-input-block">
                        <input type="text" name="buses_approve_date" value="{{$buses->buses_approve_date}}" lay-verify="required"  placeholder="请输入车辆审验时间" autocomplete="off" class="layui-input" >
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">发车时间</label>
                    <div class="layui-input-inline">
                        <input type="text" name="buses_start_date" value="{{$buses->buses_start_date}}" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">返回时间</label>
                    <div class="layui-input-inline">
                        <input type="text" name="buses_end_date" value="{{$buses->buses_end_date}}"  lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">往返时间填写格式例如时间多的用,号隔开（发车时间;6:20,12:10返回时间:9:10,5:20）</div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">车主</label>
                    <div class="layui-input-inline">
                        <input type="text" name="buses_boss" value="{{$buses->buses_boss}}" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">车主电话</label>
                    <div class="layui-input-inline" style="width:300px;">
                        <input type="text" name="buses_phone" value="{{$buses->buses_phone}}" lay-verify="required" autocomplete="off" class="layui-input">
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
                                <option value="{{$d->id}}" @if($d->id == $buses->buses_driver_id) selected @endif>{{$d->driver_name}}</option>
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
                <button class="layui-btn" lay-submit="" lay-filter="demo2">修改班车</button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        layui.use(['element','upload','form'],function(){
            var $ = layui.jquery,
                form = layui.form,
                element = layui.element;//Tab的切换功能，切换事件监听等，需要依赖element模块
            //表单初始值
            form.val("edit", {
                "busesroute_id": '{{$buses->busesroute_id}}',
            });
        });
    </script>
    {{--提示代码--}}
    @include('component.errorsLayer')
@endsection
