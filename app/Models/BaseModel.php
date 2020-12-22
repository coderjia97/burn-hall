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
    public $dao;

    public function get($id)
    {
        return $this->dao->where(['id' => $id])->first()->toArray();
    }

    public function search($conditions, $orders, $offset, $limit,$select='*')
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
