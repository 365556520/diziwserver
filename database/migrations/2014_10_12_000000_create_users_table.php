<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
<<<<<<< HEAD
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('headimg')->nullable();
            //网页字段第三方登录
            $table->string('provider')->nullable();  //第三方登录服务商
            $table->string('provider_id')->nullable(); //第三方登录id
            //app字段第三方登录
            $table->string('app_provider_id')->nullable(); //第三方登录id
            $table->rememberToken();
            $table->timestamps();
        });
        //用户信息表
        Schema::create('user_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->string('nickname')->nullable();
            $table->string('age')->nullable();
            $table->integer('sex')->nullable();
            $table->string('ipone')->nullable();
            $table->string('qq')->nullable();
            $table->string('address')->nullable(); /*家庭住址*/
            $table->string('hobby')->nullable();//   个人爱好
            $table->string('Readme')->nullable();//     自述
            $table->timestamps();
        });
    }
=======
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

>>>>>>> 21ec9b11ce76e17dcd64855928ef718e80336593
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
<<<<<<< HEAD
        Schema::dropIfExists('user_data');
=======
>>>>>>> 21ec9b11ce76e17dcd64855928ef718e80336593
    }
}
