<?php
/**
 * Sunny 2020/12/15 上午9:38
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\User\Dao;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDao extends BaseModel
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'user';
}
