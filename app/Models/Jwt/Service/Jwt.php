<?php

namespace App\Models\Jwt\Service;

use App\Models\BaseModel;
use Firebase\JWT\JWT as FirebaseJWT;

class Jwt extends BaseModel
{
    public function generateAssetsTokenByGuid($guid)
    {
        if ('' == $guid) {
            return false;
        }

        return FirebaseJWT::encode($this->generateDefaultConfigByGuid($guid), config('jwt.secretKey'));
    }

    public function decode($assetsToken): array
    {
        return (array)FirebaseJWT::decode($assetsToken, config('jwt.secretKey'), ['HS256']);
    }

    protected function generateDefaultConfigByGuid($guid): array
    {
        return [
            'iss' => config('jwt.iss'),
            'iat' => time(),
            'exp' => time() + config('jwt.exp'),
            'signature' => config('jwt.signature'),
            'guid' => $guid,
        ];
    }
}
