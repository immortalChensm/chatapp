<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDeathTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_death', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->comment("发讣告用户id");
            $table->unsignedBigInteger("deathUserId")->unique()->comment("死亡人");
            $table->dateTime("deathDate")->comment("死亡时间");
            $table->text("life")->comment("生平");
            $table->string("funeralAddress")->comment("治丧地");
            $table->string("funeral")->comment("治丧委员会");
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
        Schema::dropIfExists('user_death');
    }
}
