<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *商品管理
     * @return void
     */
    public function up()
    {
        //商品分类
        Schema::create('goodscategorys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('goodscategorys_name')->default("")->comment('商品分类别名称');
            $table->integer('goodscategorys_order')->default(0)->comment('分类排序');
            $table->integer('goodscategorys_pid')->default(0)->comment('父类id');
            $table->timestamps();
        });
        //商品信息表
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->string('goods_name')->default("")->comment('商品名字');
            $table->string('goods_title')->default("")->comment('商品标题');
            $table->string('goods_img')->default("")->nullable()->comment('商品图片');
            $table->string('discount')->default("")->nullable()->comment('优惠信息');
            $table->text('information')->comment('商品信息');
            $table->integer('goodscategorys_id')->default(0)->comment('商品分类id');
            $table->integer('shop_price')->default(0)->comment('商品零售价格');
            $table->integer('cost_price')->default(0)->comment('商品进价');
            $table->string('goods_status')->default('')->comment('商品状态如热销等');
            $table->string('aytype')->default('')->comment('商品计价单位');
            $table->integer('goods_number')->default(0)->comment('商品规格');
            $table->integer('inventory')->default(0)->comment('商品库存');
            $table->integer('sell')->default(0)->comment('商品销量');
            $table->timestamps();
        });
        //进货表
        Schema::create('goodsstock', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->integer('goods_id')->default(0)->comment('商品id');
            $table->string('remark')->default('')->comment('备注');
            $table->integer('count')->default(0)->comment('进货数量');
            $table->string('type')->default('')->comment('进货单位');
            $table->integer('price')->default(0)->comment('实付价格');
            $table->timestamps();
        });

        //订单信息表
        Schema::create('goodsorder', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->integer('goods_id')->default(0)->comment('商品id');
            $table->string('remark')->default('')->comment('备注');
            $table->integer('buycount')->default(0)->comment('购买数量');
            $table->string('state')->default('')->comment('订单状态');
            $table->integer('totalprices')->default(0)->comment('实付价格');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goodscategorys');
        Schema::dropIfExists('goods');
        Schema::dropIfExists('goodsstock');
        Schema::dropIfExists('goodsorder');
    }
}
