<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpgradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upgrade', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("userId")->index()->comment("升级的用户");
            $table->unsignedInteger("shipNum")->default(0)->comment("升级时消费的船票");
            $table->unsignedInteger("storageSize")->default(0)->comment("升级时涨的空间大小");
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
        Schema::dropIfExists('upgrade');
    }
}
