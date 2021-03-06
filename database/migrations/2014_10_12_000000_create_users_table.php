<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->default('/images/avatars/default.png');//头像
            $table->string('confirmation_token');
            $table->smallInteger('is_active')->default(0);//邮箱是否激活
            $table->integer('questions_count')->default(0);//问题数
            $table->integer('answers_count')->default(0);//回答数
            $table->integer('comments_count')->default(0);//评论数量
            $table->integer('favorites_count')->default(0);//收藏
            $table->integer('likes_count')->default(0);//点赞数
            $table->integer('followers_count')->default(0);//关注
            $table->integer('followings_count')->default(0);//被关注
            $table->json('settings')->nullable();
            $table->string('api_token',64)->unique();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
