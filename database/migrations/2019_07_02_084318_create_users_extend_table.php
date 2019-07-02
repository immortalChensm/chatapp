<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersExtendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_extend', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->unique()->comment("userid");
            $table->string("loginIp")->index()->comment("登录ip");
            $table->unsignedBigInteger("loginCount")->default(0)->comment("登录次数");
            $table->boolean("canLogin")->default(1)->comment("能否登录");
            $table->boolean("canPost")->default(1)->comment("能否发布文章");
            $table->boolean("canPhoto")->default(1)->comment("能否发布相册");
            $table->boolean("canMusic")->default(1)->comment("能否发布音乐");
            $table->boolean("canVideo")->default(1)->comment("能否发布视频");
            $table->boolean("canComment")->default(1)->comment("能否发布评论");
            $table->dateTime("loginDate")->comment("登录时间");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_extend');
    }
}
