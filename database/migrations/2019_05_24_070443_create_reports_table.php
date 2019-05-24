<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->index()->comment("举报人ID");
            $table->unsignedBigInteger("modelId")->index()->comment("举报的数据id");
            $table->unsignedTinyInteger("modelType")->comment("举报类型1文章2相册3音乐4视频");
            $table->unsignedTinyInteger("reasonId")->index()->comment("举报原因id");
            $table->string("reason")->nullable()->comment("举报具体原因");
            $table->char("contact")->nullable()->comment("举报者联系信息");
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
        Schema::dropIfExists('reports');
    }
}
