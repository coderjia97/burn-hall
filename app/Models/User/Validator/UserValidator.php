<?php
/**
 * Sunny 2020/12/14 下午4:42
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\User\Validator;

use App\Models\BaseValidator;

class UserValidator extends BaseValidator
{
    protected $rule = [
        'guid' => 'required|max:20',
        'name' => 'required|max:20',
        'password' => 'required|max:30',
        'group' => 'required',
        'source' => 'required',
    ];

    protected $message = [
        'guid.required' => '请传入用户编号',
        'name.required' => '请输入账号',
        'name.max' => '账号错误',
        'password.required' => '请输入密码',
        'password.max' => '密码错误',
        'group.required' => '请选择用户组',
        'source.required' => '来源为空',
    ];

    protected $scene = [
        'create' => ['name', 'password', 'group'],
        'update' => ['name'],
        'login' => ['name', 'password', 'source'],
        'power' => ['guid'],
    ];
}
