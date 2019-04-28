<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            //
            $table->increments('userId');
            $table->char("account",50)->unique()->comment("管理员账号");
            $table->char("password")->comment("管理员密码");
            $table->integer("roleId")->nullable()->unsigned()->comment("管理员角色id");
            $table->integer("loginIp")->nullable()->unsigned()->comment("管理员登录ip");
            $table->integer("loginTime")->nullable()->unsigned()->comment("管理员最近登录时间");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('managers');
    }
}
