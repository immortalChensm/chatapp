<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePraiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('praise', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->index()->comment("点赞用户id");
            $table->unsignedBigInteger("modelId")->index()->comment("点赞的数据id");
            $table->tinyInteger("modelType")->comment("1为文章2图片3音乐4视频");
            $table->unsignedBigInteger("praiseUserId")->index()->comment("被点赞的用户id");
            $table->tinyInteger("praiseType")->comment("赞类型1为支持2为踩");
            $table->tinyInteger("status")->comment("1为踩或赞状态0为未赞或啃状态即取消");
            $table->dateTime("day")->index()->comment("点赞日期");
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
        Schema::dropIfExists('praise');
    }
}
