<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->string('guid', 32)->comment('guid');
            $table->string('name')->comment('用户名');
            $table->string('email')->default('')->comment('email');
            $table->string('password')->comment('密码');
            $table->string('salt', 16)->comment('密码盐');
            $table->unsignedInteger('group')->comment('所属用户组');
            $table->unsignedTinyInteger('isAdmin')->comment('是否为管理员');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态: 1 开启;0 关闭');
            $table->string('refreshToken')->default('')->comment('refreshToken');
            $table->timestamp('createTime')->nullable()->comment('创建时间');
            $table->unsignedInteger('createUserId')->nullable()->comment('创建用户');
            $table->timestamp('updateTime')->nullable()->comment('更新时间');
            $table->unsignedInteger('updateUserId')->nullable()->comment('更新用户');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
}
