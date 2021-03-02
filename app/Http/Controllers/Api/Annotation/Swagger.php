<?php
/**
 * Sunny 2021/2/5 下午4:14
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Annotation;

/**
 * @Annotation
 *
 * @OA\Info(
 *     title="whell-laravel-api-documentation",
 *     version="v1.0.0"
 * )
 *
 * @OA\SecuritySchemes(
 *     type="apiKey",
 *     in="header",
 *     securityScheme="assetsToken",
 *     name="assetsToken",
 * )
 *
 * @OA\Schema(
 *     schema="accept",
 *     default="application/whell.api+json",
 * )
 *
 * @OA\Schema(
 *     schema="paging",
 *     @OA\Property(property="total",type="integer",description="总数",example=1),
 *     @OA\Property(property="offset",type="integer",description="从第几个开始取",example=0),
 *     @OA\Property(property="limit",type="integer",description="取了几个",example=20),
 * )
 */
class Swagger
{
}
