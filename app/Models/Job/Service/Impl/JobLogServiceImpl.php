<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\Job\Service\Impl;

use App\Models\BaseService;
use App\Models\Job\Dao\JobLogDao;
use App\Models\Job\Service\JobLogService;

class JobLogServiceImpl extends BaseService implements JobLogService
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

    public function getJobLogs($jobId)
    {
        $conditions = [
            ['parentId', '=', $jobId],
        ];

        return $this->getJobLogDao()->searchByPagination($conditions);
    }

    private function getJobLogDao(): JobLogDao
    {
        return $this->getDao('Job:JobLog');
    }
}
