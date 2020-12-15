<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\Job\Service;

use App\Models\BaseModel;
use App\Models\Job\Dao\JobLogDao;

class JobLogService extends BaseModel
{
    public const RESULTED_TRUE = 1;
    public const RESULTED_FALSE = 0;

    public function createSuccessLog($jobName, $jobExpression, $jobClass, $parentId, $args, $costTime)
    {
        return $this->getJobLogDao()->create([
            'parentId' => $parentId,
            'name' => $jobName,
            'expression' => $jobExpression,
            'class' => $jobClass,
            'args' => $args,
            'resulted' => self::RESULTED_TRUE,
            'trace' => '',
            'costTime' => $costTime,
        ]);
    }

    public function createFailureLog($jobName, $jobExpression, $jobClass, $parentId, $args, $costTime, $trace)
    {
        return $this->getJobLogDao()->create([
            'parentId' => $parentId,
            'name' => $jobName,
            'expression' => $jobExpression,
            'class' => $jobClass,
            'args' => $args,
            'resulted' => self::RESULTED_FALSE,
            'trace' => $trace,
            'costTime' => $costTime,
        ]);
    }

    private function getJobLogDao(): JobLogDao
    {
        return $this->getDao('Job:JobLogDao');
    }
}
