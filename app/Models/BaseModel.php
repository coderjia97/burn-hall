<?php
/**
 * Sunny 2020/12/15 下午8:51
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
    public const DELETED_AT = 'deleteTime';
    public $dao;

    public function get($id)
    {
        $result = $this->dao->where(['id' => $id])->first();

        return empty($result) ? [] : $result->toArray();
    }

    public function search($conditions, $orders, $offset, $limit, $select = '*')
    {
        $builder = $this->dao->where($conditions);

        foreach ($orders as $key => $order) {
            $builder = $builder->orderBy($key, $order);
        }

        return $builder->skip($offset)->take($limit)->select($select)->get()->toArray();
    }

    public function count($conditions)
    {
        return $this->dao->where($conditions)->count();
    }

    protected function getOffsetAndLimit(): array
    {
        $offset = request('offset', config('pagination.defaultPagingOffset'));
        $limit = request('limit', config('pagination.defaultPagingLimit'));

        return [$offset, $limit];
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
