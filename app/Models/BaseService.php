<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models;

use App\Models\User\Provider\CurrentUserProvider;
use Illuminate\Database\Eloquent\Model;

class BaseService extends Model implements BaseServiceInterface
{
    public function buildOrderBy($orm, $orderBy)
    {
        foreach ($orderBy as $key => $order) {
            $orm = $orm->orderBy($key, $order);
        }

        return $orm;
    }

    protected function getService($service, $version = '')
    {
        return app('modelHelper')->getService($service, $version);
    }

    protected function getDao($dao, $version = '')
    {
        return app('modelHelper')->getDao($dao, $version);
    }

    protected function getCurrentUser(): CurrentUserProvider
    {
        return app('user');
    }
}
