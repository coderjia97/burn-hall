<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Menu extends Migration
{
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->string('name')->comment('菜单名称');
            $table->unsignedInteger('parentId')->comment('父菜单id');
            $table->unsignedInteger('level')->comment('层级');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态: 1 开启;0 关闭');
            $table->string('route')->default('')->comment('route');
            $table->string('icon')->default('')->comment('icon');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->string('type')->default('')->comment('请求类型 GET POST UPDATE PUT DELETE');
            $table->timestamp('createTime')->nullable()->comment('创建时间');
            $table->unsignedInteger('createUserId')->nullable()->comment('创建用户');
            $table->timestamp('updateTime')->nullable()->comment('更新时间');
            $table->unsignedInteger('updateUserId')->nullable()->comment('更新用户');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
}
