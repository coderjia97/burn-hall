<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\Job\Service;

use App\Models\BaseServiceInterface;

interface JobLogService extends BaseServiceInterface
{
    public function createSuccessLog($jobName, $jobExpression, $jobClass, $parentId, $args, $costTime);

    public function createFailureLog($jobName, $jobExpression, $jobClass, $parentId, $args, $costTime, $trace);
}
