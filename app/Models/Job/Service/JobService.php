<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\Job\Service;

use App\Models\BaseServiceInterface;

interface JobService extends BaseServiceInterface
{
    public function get($id);

    public function getFirstJob();

    public function setNextTime($job, $isExecution = false);

    public function refreshJob();

    public function getByClass($class): array;

    public function updateStatus($id, $status): bool;

    public function searchByPagination($conditions);
}
