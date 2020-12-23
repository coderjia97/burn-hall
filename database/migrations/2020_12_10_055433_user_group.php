<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserGroup extends Migration
{
    public function up(): void
    {
        Schema::create('user_group', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->string('name')->comment('用户组名称');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态: 1 开启;0 关闭');
            $table->timestamp('createTime')->nullable()->comment('创建时间');
            $table->unsignedInteger('createUserId')->nullable()->comment('创建用户');
            $table->timestamp('updateTime')->nullable()->comment('更新时间');
            $table->unsignedInteger('updateUserId')->nullable()->comment('更新用户');
            $table->string('rules')->nullable()->comment('权限规则ID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_group');
    }
}
