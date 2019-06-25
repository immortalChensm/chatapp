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
            $table->string("Introduction")->comment("群简介");
            $table->string("FaceUrl")->comment("群头像");
            $table->unsignedInteger("MemberNum")->default(0)->comment("目前人数");
            $table->unsignedInteger("LastMsgTime")->default(0)->comment("当前群的最后活跃时间");
            $table->unsignedInteger("CreateTime")->default(0)->comment("当前群的创建时间");
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
