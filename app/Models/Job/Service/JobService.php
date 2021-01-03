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

    public function refreshJob()
    {
        $basePath = base_path().'/app/Models/';
        $models = scandir($basePath);
        $jobClasses = [];
        foreach ($models as $model) {
            $jobPath = $basePath.$model.'/Job';
            if ('..' != $model && '.' != $model && is_dir($jobPath)) {
                foreach (scandir($jobPath) as $job) {
                    if (preg_match('/.+Job\.php$/', $job)) {
                        $jobClasses[] = '\App\Models\\'.$model.'\Job\\'.str_replace('.php', '', $job);
                    }
                }
            }
        }

        foreach ($jobClasses as $jobName) {
            $obj = new $jobName();
            $job = $this->getByClass(substr($jobName, 1));
            if (empty($job)) {
                $cron = new CronExpression($obj->expression);

                $this->getJobDao()->create([
                    'name' => $obj->name,
                    'expression' => $obj->expression,
                    'class' => substr($jobName, 1),
                    'args' => json_encode($obj->args),
                    'nextExecutionTime' => $cron->getNextRunDate()->format('Y-m-d H:i:s'),
                    'lastExecutionTime' => null,
                    'status' => $obj->status,
                ]);
                continue;
            }

            $cron = new CronExpression($obj->expression);

            $this->getJobDao()->where('id', $job['id'])->update([
                'name' => $obj->name,
                'expression' => $obj->expression,
                'class' => substr($jobName, 1),
                'args' => json_encode($obj->args),
                'nextExecutionTime' => $cron->getNextRunDate()->format('Y-m-d H:i:s'),
                'lastExecutionTime' => null,
                'status' => $obj->status,
            ]);
        }

        $jobs = $this->getJobDao()->get()->toArray();
        $oldJobClasses = array_map(function ($class) {
            return '\\'.$class;
        }, array_column($jobs, 'class'));

        $diffClass = array_diff($oldJobClasses, $jobClasses);

        foreach ($jobs as $job) {
            if (in_array('\\'.$job['class'], $diffClass)) {
                $this->getJobDao()->where('id', $job['id'])->delete();
            }
        }
    }

    public function getByClass($class): array
    {
        $job = $this->getJobDao()->where(['class' => $class])->first();

        return $job ? $job->toArray() : [];
    }

    private function getJobDao(): JobDao
    {
        return $this->getDao('Job:JobDao');
    }
}
