<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Job extends Migration
{
    public function up(): void
    {
        Schema::create('job', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->string('name')->comment('任务名称');
            $table->string('expression')->comment('触发表达式');
            $table->string('class')->comment('任务类名');
            $table->string('args')->default('[]')->comment('参数');
            $table->timestamp('nextExecutionTime')->nullable()->comment('下一次执行时间');
            $table->timestamp('lastExecutionTime')->nullable()->comment('上一次执行时间');
            $table->unsignedTinyInteger('status')->comment('是否启用');
            $table->timestamp('createTime')->nullable()->comment('创建时间');
            $table->timestamp('updateTime')->nullable()->comment('更新时间');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job');
    }
}
