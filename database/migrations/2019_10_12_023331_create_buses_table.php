<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //线路
        Schema::create('busesroute', function (Blueprint $table) {
            $table->increments('id');
            $table->string('buses_start')->comment('起点');
            $table->string('buses_midway')->nullable()->comment('途经');
            $table->string('buses_end')->comment('终点');
            $table->integer('buses_pid')->default(0)->comment('父类id');
            $table->timestamps();
        });
        //驾驶员
        Schema::create('driver', function (Blueprint $table) {
            $table->increments('id');
            $table->string('driver_name')->comment('驾驶员名字');
            $table->string('driver_sex')->comment('驾驶员性别');
            $table->string('driver_photo')->nullable()->comment('驾驶员照片');
            $table->text('driver_info')->comment('驾驶信息');
            $table->integer('driver_age')->comment('驾驶员年龄');
            $table->string('driver_card_firstdata')->comment('初领日期');
            $table->string('driver_permit')->comment('准驾车型');
            $table->string('driver_archive_number')->comment('驾驶证档案号');
            $table->string('driver_card')->comment('驾驶证号');
            $table->string('driver_qualification')->comment('从业资格证号');
            $table->string('driver_card_date')->comment('驾驶证审验有效时间');
            $table->string('driver_qualification_date')->comment('资格证审验有效时间');
            $table->string('driver_phone')->comment('电话');
            $table->timestamps();
        });
        //班车
        Schema::create('buses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('busesroute_id')->unsigned();
            $table->string('buses_name')->comment('车号');
            $table->string('buses_type')->comment('车型');
            $table->string('buses_sit')->comment('核载');
            $table->string('buses_approve_date')->comment('车辆审验时间');
            $table->string('buses_insurance_date')->comment('保险期限');
            $table->integer('buses_driver_id')->unsigned()->comment('驾驶员');
            $table->string('buses_boss')->comment('车主');
            $table->string('buses_phone')->comment('随车电话');
            $table->string('buses_start_date')->comment('发车时间');
            $table->string('buses_end_date')->comment('返回时间');
            //外检约束更新和删除都绑定
            $table->foreign('busesroute_id')->references('id')->on('busesroute') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('buses_driver_id')->references('id')->on('driver') ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('buses');
        Schema::dropIfExists('busesroute');
        Schema::dropIfExists('driver');

    }
}
