<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedpacketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redpacket', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->comment("红包发布的人");
            $table->unsignedDecimal("money",10,2)->default(0)->comment("红包金额");
            $table->tinyInteger("type")->default(1)->comment("1为群2为个人红包");
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
        Schema::dropIfExists('redpacket');
    }
}
