<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\User\Filter;

use App\Http\Controllers\Api\Annotation\Filter;

class UserFilter extends Filter
{
    protected $mode = self::SIMPLE_MODE;

    protected $simpleFields = [
        'id', 'name', 'groupName', 'email', 'createTime', 'updateTime', 'status',
    ];
}
