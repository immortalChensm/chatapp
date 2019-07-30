<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeathTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('death', function (Blueprint $table) {
            $table->increments('id');
            $table->char("name",50)->index()->nullable()->comment("姓名");
            $table->char("deathUserId")->index()->nullable()->comment("死亡人id");
            $table->string("headImg")->nullable()->comment("头像");
            $table->string("birthAddress")->nullable()->comment("出生地");
            $table->string("locationAddress")->nullable()->comment("常驻地");
            $table->char("usedName",50)->nullable()->comment("小名");
            $table->string("description")->nullable()->comment("个人简介");
            $table->dateTime("birthday")->nullable()->comment("出生");
            $table->dateTime("deathDay")->nullable()->comment("死亡日");
            $table->boolean("sex")->nullable()->default(1)->comment("性别");
            $table->unsignedInteger("userId")->index()->comment("添加人");
            $table->dateTime("addTime")->nullable()->comment("添加时间");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('death');
    }
}
