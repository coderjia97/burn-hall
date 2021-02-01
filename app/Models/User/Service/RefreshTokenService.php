<?php

namespace App\Models\User\Service;

use App\Models\BaseServiceInterface;

interface RefreshTokenService extends BaseServiceInterface
{
    public function generateToken($userId);

    public function getToken($token);
}
