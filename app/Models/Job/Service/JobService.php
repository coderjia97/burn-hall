<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\Job\Service;

use App\Models\BaseModel;
use App\Models\Job\Dao\JobDao;
use Cron\CronExpression;

class JobService extends BaseModel
{
    public const STATUS_TRUE = 1;
    public const STATUS_FALSE = 0;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->dao = $this->getJobDao();
    }

    public function getFirstJob()
    {
        return $this->getJobDao()
            ->where([
                ['nextExecutionTime', '<=', date('Y-m-d H:i:s')],
                ['status', '=', self::STATUS_TRUE],
            ])
            ->first();
    }

    public function setNextTime($job, $isExecution = false)
    {
        $cron = new CronExpression($job['expression']);

        $data['nextExecutionTime'] = $cron->getNextRunDate()->format('Y-m-d H:i:s');
        if ($isExecution) {
            $data['lastExecutionTime'] = date('Y-m-d H:i:s');
        }

        return $this->getJobDao()
            ->where([
                ['id', '=', $job['id']],
            ])
            ->update($data);
    }

    private function getJobDao(): JobDao
    {
        return $this->getDao('Job:JobDao');
    }
}
