<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserRefreshToken extends Migration
{
    public function up(): void
    {
        Schema::create('user_refresh_token', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->unsignedInteger('userId')->comment('UserId');
            $table->string('token')->default('')->comment('token');
            $table->timestamp('expirationTime')->nullable()->comment('过期时间');
            $table->timestamp('createTime')->nullable()->comment('创建时间');
            $table->timestamp('updateTime')->nullable()->comment('更新时间');

            $table->unique('token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_log');
    }
}
