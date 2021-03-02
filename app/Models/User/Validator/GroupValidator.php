<?php

namespace App\Models\User\Validator;

use App\Models\BaseValidator;

class GroupValidator extends BaseValidator
{
    protected $rule = [
        'id' => 'required',
        'name' => 'required|max:10',
        'rules' => 'required',
    ];

    protected $message = [
        'id.required' => '请输入角色编号',
        'name.required' => '请输入名称',
        'rules.required' => '请选择权限',
    ];

    protected $scene = [
        'create' => ['name', 'rules'],
        'update' => ['rules'],
    ];
}
