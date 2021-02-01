<?php
/**
 * Sunny 2021/1/10 下午6:28
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\User\Service\Impl;

use App\Exceptions\Exception;
use App\Models\BaseService;
use App\Models\Jwt\Service\JwtService;
use App\Models\User\Dao\RefreshToken;
use App\Models\User\Service\RefreshTokenService;

class RefreshTokenServiceImpl extends BaseService implements RefreshTokenService
{
    public function generateToken($userId)
    {
        $token = $this->getRefreshTokenDao()->where('userId', $userId)->first();
        $token = $token ? $token->toArray() : [];
        if (!$token) {
            $token = $this->getRefreshTokenDao()->create([
                'userId' => $userId,
                'token' => $this->getJwtService()->generateToken([
                    'exp' => $this->getExpirationTime(),
                    'signature' => config('jwt.signature'),
                    'userId' => $userId,
                ]),
                'expirationTime' => $this->getExpirationTime(true),
            ]);

            return $token->toArray();
        }

        $this->getRefreshTokenDao()->where('id', $token['id'])->update(['expirationTime' => $this->getExpirationTime(true)]);

        return $token;
    }

    public function getToken($token)
    {
        $token = $this->getRefreshTokenDao()->where([
            ['token', '=', $token],
            ['expirationTime', '>', date('Y-m-d H:i:s')],
        ])->first();
        if (empty($token)) {
            throw new Exception('500登陆信息过期');
        }
        $token = $token ? $token->toArray() : [];

        $this->getRefreshTokenDao()->where('id', $token['id'])->update(['expirationTime' => $this->getExpirationTime(true)]);

        return $token;
    }

    protected function getExpirationTime($date = false)
    {
        $second = 60 * 60 * 24 * 7;
        $time = time() + $second;

        return $date ? date('Y-m-d H:i:s', $time) : $time;
    }

    private function getRefreshTokenDao(): RefreshToken
    {
        return $this->getDao('User:RefreshToken');
    }

    private function getJwtService(): JwtService
    {
        return $this->getService('Jwt:Jwt');
    }
}
