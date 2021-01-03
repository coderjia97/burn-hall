<?php

namespace App\Models\User\Dao;

use App\Models\BaseModel;

class GroupDao extends BaseModel
{
    protected $table = 'user_group';

    protected $fillable = ['name', 'rules'];
}
