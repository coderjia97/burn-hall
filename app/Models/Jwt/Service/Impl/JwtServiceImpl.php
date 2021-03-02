<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\Jwt\Service\Impl;

use App\Models\BaseService;
use App\Models\Jwt\Service\JwtService;
use Firebase\JWT\JWT as FirebaseJWT;

class JwtServiceImpl extends BaseService implements JwtService
{
    public function generateAssetsTokenByGuid($guid, $source = '')
    {
        if ('' == $guid) {
            return false;
        }

        return FirebaseJWT::encode($this->generateDefaultConfigByGuid([
            'guid' => $guid,
            'source' => $source,
        ]), config('jwt.secretKey'));
    }

    public function generateToken($config)
    {
        return FirebaseJWT::encode($config, config('jwt.secretKey'));
    }

    public function decode($assetsToken): array
    {
        return (array) FirebaseJWT::decode($assetsToken, config('jwt.secretKey'), ['HS256']);
    }

    protected function generateDefaultConfigByGuid($config): array
    {
        return array_merge([
            'iss' => config('jwt.iss'),
            'iat' => time(),
            'exp' => time() + config('jwt.exp'),
            'signature' => config('jwt.signature'),
        ], $config);
    }
}
