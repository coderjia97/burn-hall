<?php
/**
 * Sunny 2020/12/15 上午9:38
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\User\Dao\Impl;

use App\Models\BaseModel;
use App\Models\User\Dao\UserDao;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDaoImpl extends BaseModel implements UserDao
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'user';
}
