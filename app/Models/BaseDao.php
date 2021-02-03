<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models;

use App\Models\User\Provider\CurrentUserProvider;
use Illuminate\Database\Eloquent\Model;

class BaseDao extends Model implements BaseDaoInterface
{
    public const CREATED_AT = 'createTime';
    public const UPDATED_AT = 'updateTime';
    public const DELETED_AT = 'deleteTime';

    public function getById($id)
    {
        $result = $this->where(['id' => $id])->first();

        return empty($result) ? [] : $result->toArray();
    }

    public function search($conditions, $orderBy, $offset, $limit, $select = '*')
    {
        $builder = $this->where($conditions);

        foreach ($orderBy as $key => $order) {
            $builder = $builder->orderBy($key, $order);
        }

        return $builder->skip($offset)->take($limit)->select($select)->get()->toArray();
    }

    public function buildOrderBy($orm, $orderBy)
    {
        foreach ($orderBy as $key => $order) {
            $orm = $orm->orderBy($key, $order);
        }

        return $orm;
    }

    public function count($conditions)
    {
        return $this->where($conditions)->count();
    }

    public function searchByPagination($conditions, $orderBy = ['createTime' => 'desc']): array
    {
        [$offset, $limit] = $this->getOffsetAndLimit();

        $data = $this->search($conditions, $orderBy, $offset, $limit);
        $count = $this->count($conditions);

        return [
            'data' => $data,
            'paging' => [
                'total' => $count,
                'offset' => $offset,
                'limit' => $limit,
            ],
        ];
    }

    protected function getOffsetAndLimit(): array
    {
        $offset = request('offset', config('pagination.defaultPagingOffset'));
        $limit = request('limit', config('pagination.defaultPagingLimit'));

        return [(int)$offset, (int)$limit];
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
