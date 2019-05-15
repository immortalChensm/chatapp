<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersSpaceOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_space_order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->comment("购买空间的用户id");
            $table->unsignedDecimal("storageSize",10,2)->default(0)->comment("购买空间的大小");
            $table->unsignedInteger("buyTime")->comment("购买时间");
            $table->unsignedInteger("expireTime")->comment("过期时间");
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
        Schema::dropIfExists('users_space_order');
    }
}
