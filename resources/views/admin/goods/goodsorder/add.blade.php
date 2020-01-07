@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        <form class="layui-form layui-form-pane" method="post" action="{{url('admin/goodsorder')}}">
            {{csrf_field()}}
            {{--用户id--}}
            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
            <input type="hidden" value="支付完成" name="state">
            <div class="layui-form-item">
                <label class="layui-form-label">商品</label>
                    <div class="layui-input-block">
                        <select name="goods_id" lay-verify="" lay-search>
                            @foreach($goods as $v)
                                    <option value="{{$v->id}}">{{$v->goods_name}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>

            <div class="layui-form-item">
                    <label class="layui-form-label">数量</label>
                    <div class="layui-input-inline">
                        <input type="text" name="buycount" lay-verify="required|v_number" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">支付</label>
                <div class="layui-input-inline">
                    <input type="text" name="totalprices" lay-verify="required|v_number" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">元</div>
            </div>
            <div class="layui-form-item  layui-form-text">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" lay-verify="required"  name="remark" class="layui-textarea">这家伙很懒没有内容</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo2">添加订单</button>
            </div>
        </form>

    </div>
@endsection
@section('js')
    <script>
        layui.use(['form', 'layedit', 'laydate'], function(){
            var form = layui.form
                ,layer = layui.layer
            //监听提交
            form.on('submit(demo2)', function(data){
           /*     layer.alert(JSON.stringify(data.field), {
                    title: '最终的提交信息'
                })*/
                return true;
            });
            //自定义验证规则
            form.verify({
                v_number: [/^[0-9]{1,9}$/, '必须数字但不能大于9位']
            });

        });
    </script>
@endsection
