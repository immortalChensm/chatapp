<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->index()->comment("评论者id");
            $table->unsignedBigInteger("modelId")->index()->comment("评论的数据id");
            $table->unsignedTinyInteger("modelType")->index()->comment("1文章2相册3音乐4视频");
            $table->unsignedBigInteger("ownerUserId")->index()->comment("被评论的用户id");
            $table->text("content")->comment("评论内容");
            $table->unsignedInteger("praise")->default(0)->comment("评论的支持数");
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
        Schema::dropIfExists('comments');
    }
}
