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
use OpenApi\Annotations as OA;

class CrontabController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/system/crontab",
     *     tags={"定时任务脚本"},
     *     summary="查询所有定时任务脚本",
     *     description="查询所有定时任务脚本",
     *     @OA\Parameter(name="accept",in="header",required=true,@OA\Schema(ref="#/components/schemas/accept")),
     *     @OA\Response(response="200",description="返回结果",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="0",type="object",
     *                     @OA\Property(property="enabled",type="bool",description="开启状态",example=true),
     *                     @OA\Property(property="minutes",type="string",description="分钟",example="*"),
     *                     @OA\Property(property="hours",type="string",description="小时",example="*"),
     *                     @OA\Property(property="dayOfMonth",type="string",description="日期",example="*"),
     *                     @OA\Property(property="months",type="string",description="月份",example="*"),
     *                     @OA\Property(property="dayOfWeek",type="string",description="星期几",example="*"),
     *                     @OA\Property(property="taskCommandLine",type="string",description="任务执行命令",example="php /Users/ogg/www/whell-laravel/artisan schedule:run >> /Users/ogg/www/whell-laravel/storage/logs/job/crontab.log 2>&1"),
     *                     @OA\Property(property="comments",type="string",description="备注",example="BurnHall scheduler Job 5ff1a4511eaaf5.95269349"),
     *                     @OA\Property(property="shortCut",type="string",description="shortCut",example=null),
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function search()
    {
        $initConfig = $this->getInitCrontab();

        return $this->getCrontabService()->findCrontab($initConfig['command']);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/system/crontab",
     *     tags={"定时任务脚本"},
     *     summary="刷新定时任务脚本",
     *     description="刷新定时任务脚本",
     *     @OA\Parameter(name="accept",in="header",required=true,@OA\Schema(ref="#/components/schemas/accept")),
     *     @OA\Parameter(name="enforce",in="query",description="是否强制刷新",@OA\Schema(type="bool",default="false")),
     *     @OA\Response(response="200", description="返回结果",
     *         @OA\MediaType(mediaType="text/html",
     *             @OA\Schema(type="integer",description="成功状态 1刷新成功 0刷新失败",example=1)
     *         )
     *     )
     * )
     */
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
        return $this->getService('System:Crontab');
    }

    private function getJobService(): JobService
    {
        return $this->getService('Job:Job');
    }
}
