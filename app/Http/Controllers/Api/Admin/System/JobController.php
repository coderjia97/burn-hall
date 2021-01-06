<?php
/**
 * Sunny 2020/12/28 下午8:43
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\System;

use App\Http\Controllers\Api\Annotation\ResponseFilter;
use App\Http\Controllers\Controller;
use App\Models\Job\Service\JobService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * @ResponseFilter(class="\App\Http\Controllers\Api\Admin\System\Filter\JobFilter", mode="simple")
     */
    public function get($id)
    {
        return $this->getJobService()->get($id);
    }

    /**
     * @ResponseFilter(class="\App\Http\Controllers\Api\Admin\System\Filter\JobFilter", mode="simple")
     */
    public function search(Request $request)
    {
        $conditions = $request->get('conditions', '[]');
        $conditions = json_decode($conditions, true);

        return $this->getJobService()->searchByPagination($conditions);
    }

    public function modify(Request $request, $id)
    {
        $status = $request->get('status');

        return $this->getJobService()->updateStatus($id, !$status);
    }

    private function getJobService(): JobService
    {
        return $this->getService('Job:Job');
    }
}
