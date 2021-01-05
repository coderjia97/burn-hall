<?php

namespace App\Models\User\Dao\Impl;

use App\Models\BaseModel;
use App\Models\User\Dao\GroupDao;

class GroupDaoImpl extends BaseModel implements GroupDao
{
    protected $table = 'user_group';

    protected $fillable = ['name', 'rules'];
}
