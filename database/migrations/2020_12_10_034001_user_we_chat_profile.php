<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserWeChatProfile extends Migration
{
    public function up(): void
    {
        Schema::create('user_we_chat_profile', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->unsignedInteger('userId')->comment('用户id');
            $table->unsignedTinyInteger('subscribe')->default(0)->comment('是否订阅公众号: 0 未订阅;1 订阅');
            $table->string('openid', 64)->default('')->comment('openid');
            $table->string('nickname')->default('')->comment('昵称');
            $table->unsignedTinyInteger('sex')->default(0)->comment('性别: 0 未知;1 男性;2 女性');
            $table->string('city')->default('')->comment('城市');
            $table->string('country')->default('')->comment('国家');
            $table->string('province')->default('')->comment('省份');
            $table->string('language')->default('')->comment('语言');
            $table->string('headImgUrl')->default('')->comment('头像');
            $table->string('subscribeTime')->default('')->comment('关注时间');
            $table->timestamp('createTime')->nullable()->comment('创建时间');
            $table->unsignedInteger('createUserId')->nullable()->comment('创建用户');
            $table->timestamp('updateTime')->nullable()->comment('更新时间');
            $table->unsignedInteger('updateUserId')->nullable()->comment('更新用户');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_we_chat_profile');
    }
}
