<?php
/**
 * Sunny 2020/12/15 上午9:38
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\Log\Dao\Impl;

use App\Models\BaseModel;
use App\Models\Log\Dao\LogDao;

class LogDaoImpl extends BaseModel implements LogDao
{
    protected $guarded = [];
    protected $table = 'log';
    public const UPDATED_AT = null;
}
