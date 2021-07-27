<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuseseventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('busesevent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('buses_id')->comment('车辆id');
            $table->text('content')->comment('事件内容');
            $table->string('event_photo')->nullable()->comment('时间照片');
            $table->string('event_time')->comment('事件时间');
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
        Schema::dropIfExists('busesevent');
    }
}
