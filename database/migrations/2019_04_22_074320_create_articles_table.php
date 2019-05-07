<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('articleId')->unique()->comment("文章Id");
            $table->string('title')->index("title")->comment("文章标题");
            $table->text("content")->nullable()->comment("文章的内容");
            $table->text("image")->nullable()->comment("文章的图片兼容app端的文章图片存储");
            $table->integer("readCount")->unsigned()->nullable()->comment("文章阅读数量");
            $table->integer("commentCount")->unsigned()->nullable()->comment("文章评论数量");
            $table->integer("upCount")->unsigned()->nullable()->comment("文章点赞数量");
            $table->integer("downCount")->unsigned()->nullable()->comment("文章踩点数量");
            $table->unsignedInteger("userId")->nullable(false)->comment("文章发布作者Id");
            $table->unsignedTinyInteger("isStoraged")->nullable(false)->default("0")->comment("是否永久保存标志位1为永久保存");
            $table->unsignedInteger("shareCount")->default("0")->comment("文章分享次数");
            $table->unsignedTinyInteger("isShared")->default("0")->comment("文章是否已经分享1为分享");
            $table->unsignedTinyInteger("sharedLocation")->default("0")->comment("文章分享区域1小区2社区3用户");
            $table->unsignedInteger("tagId")->nullable(false)->index("tagId")->comment("文章标签Id");
            $table->unsignedTinyInteger("isDeleted")->default(0)->comment("文章软删除标志位");
            $table->unsignedTinyInteger("isShow")->default(1)->comment("文章是否屏蔽");
            $table->timestamp("sharedTime")->nullable()->comment("分享时间");
            $table->unsignedTinyInteger("userType")->default(2)->comment("发布者的身份1是普通用户users表2是管理员managers表");
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
        Schema::dropIfExists('articles');
    }
}
