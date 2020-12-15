<?php
/**
 * Sunny 2020/12/15 上午9:38
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Log extends Migration
{
    public function up(): void
    {
        Schema::create('log', function (Blueprint $table) {
            $table->unsignedInteger('id')->comment('id');
            $table->unsignedTinyInteger('level')->comment('等级');
            $table->unsignedInteger('userId')->comment('操作用户id');
            $table->string('ip', 64)->comment('ip');
            $table->string('message')->comment('日志内容');
            $table->text('data')->comment('日志数据');
            $table->timestamp('createTime')->nullable()->comment('创建时间');

            $table->primary('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log');
    }
}
