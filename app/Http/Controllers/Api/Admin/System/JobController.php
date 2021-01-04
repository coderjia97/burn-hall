<?php
/**
 * Sunny 2020/12/28 下午8:43
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Job\Service\JobService;

class JobController extends Controller
{
    public function get($id)
    {
        echo '<pre>';
        print_r($id);
        echo '</pre>';
    }

    public function search()
    {
        return $this->getJobService()->search([], [], 0, PHP_INT_MAX);
    }

    private function getJobService(): JobService
    {
        return $this->getService('Job:Job');
    }
}
