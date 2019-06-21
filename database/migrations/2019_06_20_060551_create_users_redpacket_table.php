<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRedpacketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_redpacket', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->index()->comment("红包领取人");
            $table->unsignedBigInteger("sendUserId")->index()->comment("红包发送人");
            $table->unsignedDecimal("money",10,2)->default(0)->comment("红包领取金额");
            $table->unsignedInteger("redpacketid")->comment("抢到的红包");
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
        Schema::dropIfExists('users_redpacket');
    }
}
