<?php
/**
 * Sunny 2020/12/28 下午8:43
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\System;

use App\Http\Controllers\Api\Annotation\ResponseFilter;
use App\Http\Controllers\Controller;
use App\Models\Job\Service\JobService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="JobData",
 *     type="object",
 *     @OA\Property(property="id",type="integer",description="id",example=1),
 *     @OA\Property(property="name",type="string",description="名称",example="testJob1"),
 *     @OA\Property(property="expression",type="string",description="任务执行表达式",example="*\1 * * * *"),
 *     @OA\Property(property="class",type="string",description="执行任务类名",example="App\Models\Job\Job\TestJob"),
 *     @OA\Property(property="args",type="string",description="参数",example="[]"),
 *     @OA\Property(property="nextExecutionTime",type="string",description="下次执行时间",example="2021-03-01 16:23:00"),
 *     @OA\Property(property="lastExecutionTime",type="string",description="上次执行时间",example=null),
 *     @OA\Property(property="status",type="integer",description="状态 1启用 0禁用",example=1),
 * )
 */
class JobController extends Controller
{
    /**
     * @ResponseFilter(class=\App\Http\Controllers\Api\Admin\System\Filter\JobFilter::class, mode="simple")
     *
     * @OA\Get(
     *     path="/api/admin/system/job/{id}",
     *     tags={"定时任务"},
     *     summary="查询定时任务",
     *     description="查询定时任务",
     *     @OA\Parameter(name="accept",in="header",required=true,@OA\Schema(ref="#/components/schemas/accept")),
     *     @OA\Parameter(name="id",in="path",required=true,description="定时任务id",@OA\Schema(type="int")),
     *     @OA\Response(response="200",description="返回结果",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/JobData")
     *         )
     *     )
     * )
     *
     * @param $id
     *
     * @return mixed
     */
    public function get($id)
    {
        return $this->getJobService()->get($id);
    }

    /**
     * @ResponseFilter(class=\App\Http\Controllers\Api\Admin\System\Filter\JobFilter::class, mode="simple")
     *
     * @OA\Get(
     *     path="/api/admin/system/job",
     *     tags={"定时任务"},
     *     summary="查询定时任务列表",
     *     description="查询定时任务列表",
     *     @OA\Parameter(name="accept",in="header",required=true,@OA\Schema(ref="#/components/schemas/accept")),
     *     @OA\Parameter(name="conditions",in="query",description="条件",
     *         @OA\Schema(
     *             @OA\Property(property="name",type="string",description="名称"),
     *         )
     *     ),
     *     @OA\Parameter(name="offset",in="query",description="从第几个开始取",@OA\Schema(type="int",default="0")),
     *     @OA\Parameter(name="limit",in="query",description="取几个",@OA\Schema(type="int",default="20")),
     *     @OA\Response(response="200",description="返回结果",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="data",type="object",
     *                     @OA\Property(ref="#/components/schemas/JobData"),
     *                 ),
     *                 @OA\Property(property="paging",ref="#/components/schemas/paging"),
     *             )
     *         )
     *     )
     * )
     */
    public function search(Request $request): array
    {
        $conditions = $request->get('conditions', []);

        return $this->getJobService()->searchByPagination($conditions);
    }

    /**
     * @OA\Patch(
     *     path="/api/admin/system/job/{id}",
     *     tags={"定时任务"},
     *     summary="修改定时任务状态",
     *     description="修改定时任务状态",
     *     @OA\Parameter(name="accept",in="header",required=true,@OA\Schema(ref="#/components/schemas/accept")),
     *     @OA\Parameter(name="id",in="path",description="定时任务id",required=true),
     *     @OA\Parameter(name="status",in="query",description="当前状态",required=true),
     *     @OA\Response(response="200",description="返回结果",
     *         @OA\MediaType(mediaType="text/html",
     *             @OA\Schema(type="integer",description="成功状态 1刷新成功 0刷新失败",example=1)
     *         )
     *     )
     * )
     *
     * @param $id
     */
    public function modify(Request $request, $id): bool
    {
        $status = $request->get('status');

        return $this->getJobService()->updateStatus($id, !$status);
    }

    private function getJobService(): JobService
    {
        return $this->getService('Job:Job');
    }
}
