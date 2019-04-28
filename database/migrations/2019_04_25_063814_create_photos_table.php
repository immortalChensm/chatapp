<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->bigIncrements('photoId')->unique()->comment("相册Id");
            $table->string('title')->index("title")->comment("相册标题");
            $table->text("introduction")->nullable()->comment("相册简介");

            $table->integer("readCount")->unsigned()->nullable()->comment("相册阅读数量");
            $table->integer("commentCount")->unsigned()->nullable()->comment("相册评论数量");
            $table->integer("upCount")->unsigned()->nullable()->comment("相册点赞数量");
            $table->integer("downCount")->unsigned()->nullable()->comment("相册踩点数量");
            $table->unsignedInteger("userId")->index()->nullable(false)->comment("相册发布作者Id");
            $table->unsignedTinyInteger("isStoraged")->nullable(false)->default("0")->comment("是否永久保存标志位1为永久保存");
            $table->unsignedInteger("shareCount")->default("0")->comment("相册分享次数");
            $table->unsignedTinyInteger("isShared")->default("0")->comment("相册是否已经分享1为分享");
            $table->unsignedTinyInteger("sharedLocation")->default("0")->comment("相册分享区域1小区2社区3用户");

            $table->unsignedTinyInteger("isDeleted")->default(0)->comment("相册软删除标志位");
            $table->unsignedTinyInteger("isShow")->default(1)->comment("相册是否屏蔽");
            $table->timestamp("sharedTime")->nullable()->comment("分享时间");
            $table->unsignedTinyInteger("userType")->comment("发布者的身份1是普通用户users表2是管理员managers表");
            $table->unsignedTinyInteger("canShared")->default(1)->comment("是否能分享1为可以");
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
        Schema::dropIfExists('photos');
    }
}
