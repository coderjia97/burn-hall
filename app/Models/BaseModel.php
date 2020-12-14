<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public const CREATED_AT = 'createTime';
    public const UPDATED_AT = 'updateTime';

    public function getService($service, $version = '')
    {
        return app('modelHelper')->getService($service, $version);
    }

    public function getDao($dao, $version = '')
    {
        return app('modelHelper')->getDao($dao, $version);
    }

    public function transformArray($query)
    {
        return app('modelHelper')->transformArray($query);
    }
}
