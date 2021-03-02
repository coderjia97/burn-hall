<?php
/**
 * Sunny 2020/12/23 下午2:46
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\System;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class VerificationCodeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/system/verification_code",
     *     tags={"验证码"},
     *     summary="登陆验证码",
     *     description="登陆验证码",
     *     @OA\Parameter(name="config",in="query",description="验证码配置",@OA\Schema(type="string",default="flat")),
     *     @OA\Response(response="200",description="返回结果",
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="sensitive",type="bool",description="是否开启严格模式",example=false),
     *                 @OA\Property(property="key",type="string",description="验证码key",example="eyJpdiI6ImZvbUlmRUJKajFhVDdCS3gyNHo..."),
     *                 @OA\Property(property="img",type="string",description="验证码base64",example="data:image/png;base64,iVBORw0KGg...")
     *             )
     *         )
     *     )
     * )
     *
     * @param string $config
     *
     * @throws Exception
     */
    public function search($config = 'flat'): JsonResponse
    {
        return response()->json(app('captcha')->create($config, true));
    }
}
