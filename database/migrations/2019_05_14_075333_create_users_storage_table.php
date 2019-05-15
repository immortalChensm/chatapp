<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_storage', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("userId")->comment("用户id");
            $table->unsignedDecimal("totalForeverSpace",10,2)->default(0)->comment("用户的永久存储空间大小M");
            $table->unsignedDecimal("usedForeverSpace",10,2)->default(0)->comment("用户已经使用的永久存储空间大小M");

            $table->unsignedDecimal("tempSpace",10,2)->default(0)->comment("用户的临时空间大小");
            $table->unsignedDecimal("tempUsedSpace",10,2)->default(0)->comment("用户已经使用的临时存储空间M");
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
        Schema::dropIfExists('users_storage');
    }
}
