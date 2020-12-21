<?php


namespace App\Models\User\Dao;


use App\Models\BaseModel;

class GroupDao extends BaseModel
{
    protected $table = 'user_group';

    const CREATED_AT = 'createTime';

    const UPDATED_AT = 'updateTime';

    protected $fillable = ['name','rules'];
}
