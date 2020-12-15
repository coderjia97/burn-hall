<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JobLog extends Migration
{
    public function up(): void
    {
        Schema::create('job_log', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->unsignedInteger('parentId')->comment('父id');
            $table->string('name')->default('')->comment('任务名称');
            $table->string('expression')->default('')->comment('触发表达式');
            $table->string('class')->default('')->comment('任务类名');
            $table->string('args')->default('')->comment('参数');
            $table->unsignedTinyInteger('resulted')->comment('结果');
            $table->text('trace')->comment('异常信息');
            $table->string('costTime')->comment('花费时间');
            $table->timestamp('createTime')->nullable()->comment('创建时间');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_log');
    }
}
