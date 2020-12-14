<?php
/**
 * Sunny 2020/12/14 下午4:42
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models;

use App\Models\User\Provider\CurrentUserProvider;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public const CREATED_AT = 'createTime';
    public const UPDATED_AT = 'updateTime';

    protected function getService($service, $version = '')
    {
        return app('modelHelper')->getService($service, $version);
    }

    protected function getDao($dao, $version = '')
    {
        return app('modelHelper')->getDao($dao, $version);
    }

    protected function transformArray($query)
    {
        return app('modelHelper')->transformArray($query);
    }

    protected function getCurrentUser(): CurrentUserProvider
    {
        return app('user');
    }
}
