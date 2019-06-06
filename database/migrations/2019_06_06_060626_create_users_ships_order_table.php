<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersShipsOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_ships_order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->index()->comment("userid");
            $table->unsignedBigInteger("sellerUserId")->index()->comment("出售者id");
            $table->tinyInteger("type")->default(1)->comment("1用户出售的船票2是平台出售的船票");
            $table->unsignedInteger("shipNum")->default(0)->comment("出售的船票数量");
            $table->unsignedDecimal("payMoney",10,2)->default(0.00)->comment("出售金额");
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
        Schema::dropIfExists('users_ships_order');
    }
}
