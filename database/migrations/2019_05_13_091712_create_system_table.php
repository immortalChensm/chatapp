<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system', function (Blueprint $table) {
            $table->string("name")->unique()->comment("配置选项名称");
            $table->string("value")->comment("配置选项值");
            $table->string("item")->comment("配置项");
            $table->string("type")->comment("表单数据类型");
            $table->string("description")->comment("配置项说明");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system');
    }
}
