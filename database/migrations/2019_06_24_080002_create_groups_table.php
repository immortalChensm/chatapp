<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string("GroupId")->index()->comment("群组id");
            $table->string("Name")->index()->comment("群名");
            $table->string("Operator_Account")->comment("创建者");
            $table->unsignedBigInteger("Owner_Account")->index()->comment("群主id");
            $table->string("Type")->index()->comment("群类型");
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
        Schema::dropIfExists('groups');
    }
}
