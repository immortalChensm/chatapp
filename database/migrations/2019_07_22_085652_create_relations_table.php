<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger("userId")->index()->comment("userid");
            $table->text("leftNode")->nullable()->comment("leftNode");
            $table->text("rightNode")->nullable()->comment("rightNode");
            $table->text("parentNode")->nullable()->comment("parentNode");
            $table->boolean("nullNode")->nullable()->comment("是否是空框");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relations');
    }
}
