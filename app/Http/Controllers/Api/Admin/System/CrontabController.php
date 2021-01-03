<?php
/**
 * Sunny 2020/12/25 上午10:44
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Job\Service\JobService;
use App\Models\System\Service\CrontabService;
use Illuminate\Http\Request;

class CrontabController extends Controller
{
    public function search()
    {
        $initConfig = $this->getInitCrontab();

        return $this->getCrontabService()->findCrontab($initConfig['command']);
    }

    public function create(Request $request): bool
    {
        $enforce = $request->post('enforce', false);

        $initConfig = $this->getInitCrontab();
        $this->getCrontabService()->createCrontab($initConfig['time'], $initConfig['command'], $initConfig['logPath'], $enforce);
        $this->getJobService()->refreshJob();

        return true;
    }

    protected function getInitCrontab(): array
    {
        return [
            'time' => '* * * * *',
            'command' => 'php '.base_path().'/artisan schedule:run',
            'logPath' => base_path().'/storage/logs/job/crontab.log',
        ];
    }

    private function getCrontabService(): CrontabService
    {
        return $this->getService('System:CrontabService');
    }

    private function getJobService(): JobService
    {
        return $this->getService('Job:JobService');
    }
}
