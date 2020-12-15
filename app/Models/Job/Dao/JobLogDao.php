<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\Job\Dao;

use App\Models\BaseModel;

class JobLogDao extends BaseModel
{
    protected $guarded = [];
    protected $table = 'job_log';
    public const UPDATED_AT = null;
}
