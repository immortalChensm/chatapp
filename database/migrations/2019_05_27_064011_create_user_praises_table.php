<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPraisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_praises', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->index()->comment("用户id");
            $table->unsignedBigInteger("praiseNum")->default(0)->comemt("用户获得的点赞数量");
            $table->date("day")->comment("日期");
            $table->unsignedTinyInteger("type")->default(0)->comment("1为已结算船票");
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
        Schema::dropIfExists('user_praises');
    }
}
