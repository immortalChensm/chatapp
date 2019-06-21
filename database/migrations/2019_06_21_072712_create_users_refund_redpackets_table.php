<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRefundRedpacketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_refund_redpackets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->index()->comment("退还的红包用户");
            $table->unsignedBigInteger("redPacketId")->index()->comment("退还的红包id");
            $table->unsignedDecimal("money",10,2)->comment("退还金额");
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
        Schema::dropIfExists('users_refund_redpackets');
    }
}
