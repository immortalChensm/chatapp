<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('imageId')->comment("图片id");
            $table->unsignedBigInteger("photoId")->index()->comment("所属相册ID");
            $table->unsignedTinyInteger("type")->default(1)->comment("图片类型1为uri链接2为OSS上的文件key");
            $table->string("uriKey")->comment("图片链接或key");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
