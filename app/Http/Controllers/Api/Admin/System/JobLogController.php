<?php
/**
 * Sunny 2020/12/28 下午8:43
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Job\Service\JobLogService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="JobLogData",
 *     type="object",
 *     @OA\Property(property="id",type="integer",description="id",example=1),
 *     @OA\Property(property="parentId",type="integer",description="任务id",example=1),
 *     @OA\Property(property="args",type="string",description="参数",example="[]"),
 *     @OA\Property(property="resulted",type="integer",description="任务执行结果 1成功 0失败",example=1),
 *     @OA\Property(property="trace",type="string",description="异常信息",example="执行失败:test error:SQLSTATE[HY000]: General error: 1364 Field 'trace' doesn't have a default value (SQL: insert into `job_log` (`parentId`, `name`, `expression`, `class`, `args`, `resulted`, `costTime`, `createTime`) values (1, test, *\1 * * * *, App\Models\Job\Job\TestJob, [], 1, 0.016108989715576, 2020-12-15 20:46:07))line:671file:/Users/ogg/www/whell-laravel/vendor/laravel/framework/src/Illuminate/Database/Connection.php"),
 *     @OA\Property(property="costTime",type="string",description="执行花费时间",example="0.029523849487305"),
 *     @OA\Property(property="createTime",type="string",description="任务开始执行时间",example="2021-01-03T10:43:01.000000Z"),
 *     @OA\Property(property="name",type="string",description="任务名称",example="testJob1"),
 *     @OA\Property(property="expression",type="string",description="任务执行表达式",example="*\1 * * * *"),
 *     @OA\Property(property="class",type="string",description="执行任务类名",example="App\Models\Job\Job\TestJob"),
 * )
 */
class JobLogController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/system/job_log",
     *     tags={"定时任务日志"},
     *     summary="查询定时任务日志列表",
     *     description="查询定时任务日志列表",
     *     @OA\Parameter(name="accept",in="header",required=true,@OA\Schema(ref="#/components/schemas/accept")),
     *     @OA\Parameter(name="jobId",in="query",description="任务id",required=true),
     *     @OA\Parameter(name="offset",in="query",description="从第几个开始取",@OA\Schema(type="int",default="0")),
     *     @OA\Parameter(name="limit",in="query",description="取几个",@OA\Schema(type="int",default="20")),
     *     @OA\Response(response="200",description="返回结果",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="data",type="object",
     *                     @OA\Property(ref="#/components/schemas/JobLogData"),
     *                 ),
     *                 @OA\Property(property="paging",ref="#/components/schemas/paging"),
     *             )
     *         )
     *     )
     * )
     */
    public function search(Request $request): array
    {
        $jobId = $request->get('jobId');

        return $this->getJobLogService()->getJobLogs($jobId);
    }

    private function getJobLogService(): JobLogService
    {
        return $this->getService('Job:JobLog');
    }
}
