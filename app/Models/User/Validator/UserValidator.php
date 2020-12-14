<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\User\Validator;

use App\Models\BaseValidator;

class UserValidator extends BaseValidator
{
    protected $rule = [
        'name' => 'required|max:20',
        'password' => 'required|max:30',
    ];

    protected $message = [
        'name.required' => '请输入账号',
        'name.max' => '账号错误',
        'password.required' => '请输入密码',
        'password.max' => '密码错误',
    ];

    protected $scene = [
        'create' => ['name', 'password'],
    ];
}
