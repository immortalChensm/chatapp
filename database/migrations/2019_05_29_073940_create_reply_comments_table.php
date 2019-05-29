<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplyCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("userId")->index()->comment("回复者用户id");
            $table->unsignedBigInteger("commentId")->index()->comment("回复的评论id");
            $table->unsignedBigInteger("commentUserId")->index()->comment("被回复的用户id");
            $table->text("content")->comment("回复内容");
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
        Schema::dropIfExists('reply_comments');
    }
}
