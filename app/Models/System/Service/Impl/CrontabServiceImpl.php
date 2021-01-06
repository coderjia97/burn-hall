<?php
/**
 * Sunny 2020/12/15 上午9:38
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\System\Service\Impl;

use App\Models\BaseService;
use App\Models\System\Service\CrontabService;
use TiBeN\CrontabManager\CrontabAdapter;
use TiBeN\CrontabManager\CrontabJob;
use TiBeN\CrontabManager\CrontabRepository;

class CrontabServiceImpl extends BaseService implements CrontabService
{
    public function createCrontab($time, $command, $logPath = '/dev/null', $enforce = false): bool
    {
        $this->deleteCrontab($command);

        if (empty($this->findCrontab($command)) || $enforce) {
            $crontabRepository = new CrontabRepository(new CrontabAdapter());
            $crontabJob = CrontabJob::createFromCrontabLine($time.' '.$command.' >> '.$logPath.' 2>&1');
            $crontabJob->comments = 'BurnHall scheduler Job '.uniqid('', true);
            $crontabRepository->addJob($crontabJob);
            $crontabRepository->persist();
        }

        return true;
    }

    public function deleteCrontab($name): bool
    {
        $crontabRepository = new CrontabRepository(new CrontabAdapter());
        $crontabJobs = $crontabRepository->findJobByRegex('/'.str_replace('/', '\/', $name).'/');

        foreach ($crontabJobs as $crontabJob) {
            $crontabRepository->removeJob($crontabJob);
            $crontabRepository->persist();
        }

        return true;
    }

    public function findCrontab($name)
    {
        $crontabRepository = new CrontabRepository(new CrontabAdapter());

        return $crontabRepository->findJobByRegex('/'.str_replace('/', '\/', $name).'/');
    }
}
