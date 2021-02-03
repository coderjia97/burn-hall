<?php

namespace App\Models\User\Dao\Impl;

use App\Models\BaseDao;
use App\Models\User\Dao\GroupDao;

class GroupDaoImpl extends BaseDao implements GroupDao
{
    protected $table = 'user_group';

    protected $fillable = ['name', 'rules'];

    protected $casts = [
        'rules' => 'json',
    ];
}
