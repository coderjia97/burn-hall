<?php

namespace App\Http\Controllers\Api\Admin\User\Filter;

use App\Http\Controllers\Api\Annotation\Filter;

class LoginFilter extends Filter
{
    protected $mode = self::SIMPLE_MODE;

    protected $simpleFields = [
        'guid',
        'name',
        'token',
        'menus',
        'refreshToken',
    ];
}
