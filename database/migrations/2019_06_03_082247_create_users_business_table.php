<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_business', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->index()->comment("用户id");
            $table->string("name",30)->index()->comment("姓名");
            $table->string("mobile",11)->index()->comment("电话");
            $table->string("address",200)->comment("地址");
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
        Schema::dropIfExists('users_business');
    }
}
