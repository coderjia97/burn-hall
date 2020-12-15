<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Console\Commands;

use App\Models\Job\Service\JobLogService;
use App\Models\Job\Service\JobService;
use App\Toolkit\FileTools;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Job extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '消耗定时任务.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $crontabLock = base_path().'/storage/logs/job/job.lock';

        if (!FileTools::has($crontabLock)) {
            $file = fopen($crontabLock, 'wb');
            fclose($file);
        }

        $file = fopen($crontabLock, 'rb');
        if (flock($file, LOCK_EX)) {
            do {
                $job = $this->getJobService()->getFirstJob();
                if (empty($job)) {
                    continue;
                }

                $startTime = microtime(true);

                try {
                    $this->getJobService()->setNextTime($job, true);

                    $log = '开始执行:'.$job['name'].PHP_EOL;
                    $log .= '任务:'.$job['class'].PHP_EOL;
                    $log .= '参数:'.$job['args'].PHP_EOL;
                    $log .= str_repeat('----------', 50).PHP_EOL;
                    Log::channel('job')->info($log);

                    $obj = new $job['class']();
                    $obj->execute(json_decode($job['args'], true));

                    $this->getJobLogService()->createSuccessLog($job['name'], $job['expression'], $job['class'], $job['id'], $job['args'], microtime(true) - $startTime);
                } catch (\Exception $e) {
                    $trace = '执行失败:'.$job['name'].PHP_EOL.'error:'.$e->getMessage().PHP_EOL.'line:'.$e->getLine().PHP_EOL.'file:'.$e->getFile().PHP_EOL;

                    $this->getJobLogService()->createFailureLog($job['name'], $job['expression'], $job['class'], $job['id'], $job['args'], microtime(true) - $startTime, $trace);
                    Log::channel('job_error')->info($trace);
                }
            } while (!empty($this->getJobService()->getFirstJob()));

            flock($file, LOCK_UN);
            fclose($file);
        }
    }

    private function getJobService(): JobService
    {
        return app('modelHelper')->getService('Job:JobService');
    }

    private function getJobLogService(): JobLogService
    {
        return app('modelHelper')->getService('Job:JobLogService');
    }
}
