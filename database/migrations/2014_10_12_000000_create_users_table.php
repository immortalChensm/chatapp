<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->bigIncrements("userId")->comment("用户Id");

            $table->string("headImgUrl")->nullable()->comment("用户头像");
            $table->string("handNum")->nullable()->unique("handNum")->comment("用户的传联号");
            $table->unsignedInteger("star")->nullable()->default(0)->comment("用户星级");
            $table->unsignedDecimal("money",10,2)->default(0.00)->comment("用户余额");
            $table->unsignedInteger("shipNumber")->default(0)->comment("船票数量");
            $table->unsignedInteger("praiseNumber")->default(0)->comment("用户收到的点赞数量");
            $table->string("spreadCode")->unique("spreadCode")->nullable()->comment("推广码");
            $table->string("spreadQrCode")->nullable()->comment("推广二维码");
            $table->string("mobile",11)->nullable()->unique("mobile")->comment("手机号码");
            $table->string("payPassword")->nullable()->comment("支付密码");
            $table->char("realName",50)->index()->nullable()->comment("真实姓名");
            $table->unsignedTinyInteger("sex")->nullable(false)->default(1)->unique()->comment("性别1男2女");
            $table->unsignedInteger("birthday")->nullable()->comment("生日");
            $table->char("petName",50)->nullable()->comment("小名");

            $table->unsignedInteger("birthPlaceProvinceId")->nullable()->comment("出生地所在省份ID");
            $table->unsignedInteger("birthPlaceCityId")->nullable()->comment("出生地所在市ID");
            $table->unsignedInteger("birthPlaceCountryId")->nullable()->comment("出生地所在县ID");
            $table->unsignedInteger("birthPlaceTownId")->nullable()->comment("出生地所在镇ID");


            //$table->string("birthPlace")->comment("出生地");
            //$table->string("location")->comment("常驻地");

            $table->unsignedInteger("locationProvinceId")->nullable()->comment("常驻地所在省份ID");
            $table->unsignedInteger("locationCityId")->nullable()->comment("常驻地所在市ID");
            $table->unsignedInteger("locationCountryId")->nullable()->comment("常驻地所在县ID");
            $table->unsignedInteger("locationTownId")->nullable()->comment("常驻地所在镇ID");



            $table->string("introduction")->nullable()->comment("个人简介");
            $table->unsignedInteger("isValiated")->nullable()->default(0)->comment("是否实名认证1为是");
            $table->char("idCard",18)->unique()->nullable()->comment("身份证号码");
            $table->string("idCardFrontPic")->nullable()->comment("身份证正面");
            $table->string("idCardBackPic")->nullable()->comment("身份证反面");
            $table->unsignedInteger("voice")->nullable(false)->default(1)->comment("是否开户声音");
            $table->unsignedTinyInteger("vibration")->nullable(false)->default(1)->comment("是否振动1为默认振动");
            $table->unsignedTinyInteger("groupVibration")->nullable(false)->default(1)->comment("是否开户群振动");
            $table->unsignedTinyInteger("messageNotice")->nullable(false)->default(1)->comment("是否接收消息通知");
            $table->unsignedTinyInteger("disturb")->nullable(false)->default(1)->comment("消息免打扰");
            $table->unsignedTinyInteger("showMsgDetail")->nullable(false)->default(1)->comment("消息是否显示详情");

            $table->string("name")->unique("name")->nullable()->comment("用户网名");
            $table->unsignedTinyInteger("isIm")->nullable()->default(0)->commemt("是否已经导入IM系统0没有1已导入");
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
