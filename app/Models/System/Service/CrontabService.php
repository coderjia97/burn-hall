<?php
/**
 * Sunny 2020/12/15 上午9:38
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\System\Service;

use App\Models\BaseServiceInterface;

interface CrontabService extends BaseServiceInterface
{
    public function createCrontab($time, $command, $logPath = '/dev/null', $enforce = false): bool;

    public function deleteCrontab($name): bool;

    public function findCrontab($name);
}
