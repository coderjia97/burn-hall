<?php
/**
 * Sunny 2020/12/15 上午9:38
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\User\Dao\Impl;

use App\Models\BaseDao;
use App\Models\User\Dao\RefreshToken;

class RefreshTokenDaoImpl extends BaseDao implements RefreshToken
{
    protected $guarded = [];
    protected $table = 'user_refresh_token';
}
