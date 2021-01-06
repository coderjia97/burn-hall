<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\System\Filter;

use App\Http\Controllers\Api\Annotation\Filter;

class JobFilter extends Filter
{
    protected $mode = self::SIMPLE_MODE;

    protected $simpleFields = [
        'id', 'args', 'class', 'expression', 'lastExecutionTime', 'name', 'nextExecutionTime', 'status',
    ];
}
