<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models;

interface BaseDaoInterface
{
    public function getById($id);

    public function search($conditions, $orderBy, $offset, $limit, $select = '*');

    public function buildOrderBy($orm, $orderBy);

    public function count($conditions);

    public function searchByPagination($conditions, $orderBy = ['createTime' => 'desc']): array;
}
