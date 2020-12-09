<?php

namespace App\Exceptions\Middleware;

use App\Exceptions\Exception;

class AuthException extends Exception
{
    public const TOKEN_EXPIRED = 403001001;

    public $messages = [
        403001001 => '签名验证失败',
    ];
}
