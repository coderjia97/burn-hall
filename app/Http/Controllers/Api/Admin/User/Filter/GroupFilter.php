<?php

namespace App\Http\Controllers\Api\Admin\User\Filter;

use App\Http\Controllers\Api\Annotation\Filter;

class GroupFilter extends Filter
{
    protected $mode = self::SIMPLE_MODE;

    protected $simpleFields = [
        'id',
        'name',
        'status',
        'rules',
    ];
}
