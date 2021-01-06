<?php
/**
 * Sunny 2020/12/28 下午8:43
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Job\Service\JobLogService;
use Illuminate\Http\Request;

class JobLogController extends Controller
{
    public function search(Request $request)
    {
        $jobId = $request->get('jobId');

        return $this->getJobLogService()->getJobLogs($jobId);
    }

    private function getJobLogService(): JobLogService
    {
        return $this->getService('Job:JobLog');
    }
}
