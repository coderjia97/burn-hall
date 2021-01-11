<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\Jwt\Service;

use App\Models\BaseServiceInterface;

interface JwtService extends BaseServiceInterface
{
    public function generateAssetsTokenByGuid($guid);

    public function decode($assetsToken): array;
}
