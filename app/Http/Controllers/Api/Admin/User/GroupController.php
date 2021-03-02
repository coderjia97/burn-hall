<?php

namespace App\Http\Controllers\Api\Admin\User;

use App\Http\Controllers\Api\Annotation\ResponseFilter;
use App\Http\Controllers\Controller;
use App\Models\User\Service\GroupService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="GroupData",
 *     type="object",
 *     @OA\Property(property="id",type="integer",description="id",example=1),
 *     @OA\Property(property="name",type="string",description="名称",example="group1"),
 *     @OA\Property(property="status",type="integer",description="状态 1启用 0禁用",example=1),
 *     @OA\Property(property="rules",type="array",description="规则",
 *         @OA\Items(type="string",example="Index"),
 *         @OA\Items(type="string",example="UserGroup"),
 *         @OA\Items(type="string",example="..."),
 *     ),
 * )
 */
class GroupController extends Controller
{
    /**
     * @ResponseFilter(class=\App\Http\Controllers\Api\Admin\User\Filter\GroupFilter::class, mode="simple")
     *
     * @OA\Get(
     *     path="/api/admin/user/group/{id}",
     *     tags={"用户组"},
     *     summary="获取用户组",
     *     description="获取用户组",
     *     @OA\Parameter(name="accept",in="header",required=true,@OA\Schema(ref="#/components/schemas/accept")),
     *     @OA\Parameter(name="id",in="path",description="用户组id",required=true),
     *     @OA\Response(response="200",description="返回结果",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="0",ref="#/components/schemas/GroupData"),
     *             )
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
        return $this->getGroupService()->get($id);
    }

    /**
     * @OA\Delete(
     *     path="/api/admin/user/group/{id}",
     *     tags={"用户组"},
     *     summary="删除用户组",
     *     description="删除用户组",
     *     @OA\Parameter(name="accept",in="header",required=true,@OA\Schema(ref="#/components/schemas/accept")),
     *     @OA\Parameter(name="id",in="path",description="用户组id",required=true),
     *     @OA\Response(response="200",description="返回结果",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(type="integer",description="成功状态 1成功 0失败",example=1)
     *         )
     *     )
     * )
     *
     * @param $id
     */
    public function delete($id): bool
    {
        return $this->getGroupService()->deleteGroup($id);
    }

    /**
     * @ResponseFilter(class=\App\Http\Controllers\Api\Admin\User\Filter\GroupFilter::class, mode="simple")
     *
     * @OA\Get(
     *     path="/api/admin/user/group",
     *     tags={"用户组"},
     *     summary="获取用户组列表",
     *     description="获取用户组列表",
     *     @OA\Parameter(name="accept",in="header",required=true,@OA\Schema(ref="#/components/schemas/accept")),
     *     @OA\Response(response="200",description="返回结果",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="0",ref="#/components/schemas/GroupData"),
     *             )
     *         )
     *     )
     * )
     */
    public function search(Request $request): array
    {
        $conditions = $request->get('conditions', []);

        return $this->getGroupService()->searchByPagination($conditions, ['createTime' => 'desc']);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/user/group",
     *     tags={"用户组"},
     *     summary="创建用户组",
     *     description="创建用户组",
     *     @OA\Parameter(name="accept",in="header",required=true,@OA\Schema(ref="#/components/schemas/accept")),
     *     @OA\Parameter(name="name",in="query",description="用户组名称",required=true,@OA\Schema(type="string")),
     *     @OA\Parameter(name="rules",in="query",description="用户组规则",required=true,@OA\Schema(type="object")),
     *     @OA\Response(response="200",description="返回结果",
     *         @OA\MediaType(mediaType="application/json",
     *            @OA\Schema(type="integer",description="成功状态 1成功 0失败",example=1)
     *         )
     *     )
     * )
     */
    public function create(Request $request): bool
    {
        $data = $request->all();

        return $this->getGroupService()->createGroup($data);
    }

    /**
     * @OA\Put(
     *     path="/api/admin/user/group",
     *     tags={"用户组"},
     *     summary="更新用户组",
     *     description="更新用户组",
     *     @OA\Parameter(name="accept",in="header",required=true,@OA\Schema(ref="#/components/schemas/accept")),
     *     @OA\Parameter(name="name",in="query",description="用户组名称",@OA\Schema(type="string")),
     *     @OA\Parameter(name="rules",in="query",description="用户组规则",required=true,@OA\Schema(type="object")),
     *     @OA\Parameter(name="status",in="query",description="状态 1启用 0禁用",required=true,@OA\Schema(type="integer")),
     *     @OA\Response(response="200",description="返回结果",
     *         @OA\MediaType(mediaType="application/json",
     *            @OA\Schema(type="integer",description="成功状态 1成功 0失败",example=1)
     *         )
     *     )
     * )
     *
     * @param $id
     */
    public function update($id, Request $request): bool
    {
        $data = $request->all();

        return $this->getGroupService()->updateGroup($id, $data);
    }

    private function getGroupService(): GroupService
    {
        return $this->getService('User:Group');
    }
}
