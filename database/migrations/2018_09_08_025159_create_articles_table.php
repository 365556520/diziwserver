<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *文章
     * @return void
     */
    public function up()
    {
        /*文章分类列表*/
        Schema::create('categorys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cate_name')->default("")->comment('分类名字');
            $table->string('cate_keywords')->default("")->comment('关键词');
            $table->string('cate_description')->default("")->comment('描述');
            $table->integer('cate_view')->default(0)->comment('查看次数');
            $table->integer('cate_order')->default(0)->comment('分类排序');
            $table->integer('cate_pid')->default(0)->comment('父类id');
            $table->timestamps();
        });
        /*文章表*/
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default("")->comment('标题');
            $table->string('tag')->default("")->comment('关键词');
            $table->string('description')->default("")->comment('描述');
            $table->string('thumb')->default("")->comment('缩略图');
            $table->integer('view')->default(0)->comment('查看次数');
            $table->integer('state')->default(0)->comment('文章状态');
            $table->integer('level')->default(0)->comment('文章级别置顶推荐热门');
            $table->integer('category_id')->default(0)->comment('分类id');
            $table->integer('user_id')->default(0)->comment('作者id');
            $table->text('content')->comment('内容');
            $table->timestamps();
        });
        //评论列表
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('topic_id')->default(0)->comment('主题id');
            $table->string('topic_type')->default("")->nullable()->comment('主题type');
            $table->text('content')->comment('内容');
            $table->integer('from_uid')->default(0)->comment('评论用户id');
            $table->integer('comments_pid')->default(0)->comment('父子关系');
            $table->integer('to_uid')->default(0)->nullable()->comment('评论目标用户id');
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
        Schema::dropIfExists('category');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('comments');
    }
}
