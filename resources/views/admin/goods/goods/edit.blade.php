@extends('layouts.layuicontent')
@section('title')
    <title>{{ trans('admin/menu.title')}}</title>
@endsection
@section('css')
@endsection
@section('content')

    <div class="layui-row" style="padding: 2px 15px 2px 15px">
        <br>
        <form class="layui-form layui-form-pane" lay-filter="edit" method="post" action="{{url('admin/goods/'.$goodsEdit->id)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <input type="hidden" value="{{$goodsEdit->id}}" name="id">
            {{--用户id--}}
            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
            <div class="layui-form-item">
                <label class="layui-form-label">商品名字</label>
                <div class="layui-input-inline">
                    <input type="text" name="goods_name" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">商品标题</label>
                <div class="layui-input-block">
                    <input type="text" name="goods_title" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" >
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">商品分类</label>
                    <div class="layui-input-inline">
                        <select name="goodscategorys_id" lay-verify="required" lay-search="">
                            <option value="">请选择</option>
                            @foreach($categorys as $v)
                                <optgroup label="{{$v->goodscategorys_name}}">
                                    @foreach($v->children as $vl)
                                        <option value="{{$vl->id}}">{{$vl->goodscategorys_name}}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">商品状态</label>
                    <div class="layui-input-inline">
                        <input type="text" name="goods_status" lay-verify="required" placeholder="请输入"  autocomplete="off" class="layui-input" >
                    </div>
                </div>

            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">商品进价</label>
                    <div class="layui-input-inline">
                        <input type="text" name="cost_price" lay-verify="required|v_number" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">商品零售价</label>
                    <div class="layui-input-inline">
                        <input type="text" name="shop_price" lay-verify="required|v_number" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>


            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">商品库存</label>
                    <div class="layui-input-inline">
                        <input type="text" name="inventory" lay-verify="required|v_number" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">销量</label>
                    <div class="layui-input-inline">
                        <input type="text" name="sell" lay-verify="required|v_number" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">规格</label>
                    <div class="layui-input-inline">
                        <input type="text" name="goods_number" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">单位</label>
                    <div class="layui-input-inline">
                        <input type="text" name="aytype" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>


            <div class="layui-form-item">
                <label class="layui-form-label">商品图片</label>
                <div class="layui-input-block">
                    <input type="text" name="goods_img"  placeholder="选填" autocomplete="off" class="layui-input" >
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">优惠信息</label>
                <div class="layui-input-block">
                    <input type="text" name="discount" placeholder="选填" autocomplete="off" class="layui-input">
                </div>
            </div>



            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">详细信息</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" name="information" class="layui-textarea"></textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="demo2">确认修改</button>
            </div>
        </form>

    </div>

@endsection
@section('js')
    <script>
        layui.use(['form', 'layedit', 'laydate'], function(){
            var form = layui.form
                ,layer = layui.layer

            //初始值
            form.val("edit", {
                "goods_name": "{{$goodsEdit->goods_name}}",
                "goods_title": "{{$goodsEdit->goods_title}}",
                "goodscategorys_id": "{{$goodsEdit->goodscategorys_id}}",
                "goods_img": "{{$goodsEdit->goods_img}}",
                "discount": "{{$goodsEdit->discount}}",
                "information": "{{$goodsEdit->information}}",
                "shop_price": "{{$goodsEdit->shop_price}}",
                "cost_price": "{{$goodsEdit->shop_price}}",
                "goods_status": "{{$goodsEdit->goods_status}}",
                "aytype": "{{$goodsEdit->aytype}}",
                "goods_number": "{{$goodsEdit->goods_number}}",
                "inventory": "{{$goodsEdit->inventory}}",
                "sell": "{{$goodsEdit->sell}}",
            })
            //监听提交
            form.on('submit(demo2)', function(data){
       /*         layer.alert(JSON.stringify(data.field), {
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
