<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\User\Filter;

use App\Http\Controllers\Api\Annotation\Filter;
use App\Models\User\Service\GroupService;
use App\Toolkit\ArrayTools;

class UserFilter extends Filter
{
    protected $mode = self::SIMPLE_MODE;

    protected $simpleFields = [
        'id','name','group','email','createTime','updateTime'
    ];

//    protected function simpleFields(&$data)
//    {
//    }
}
