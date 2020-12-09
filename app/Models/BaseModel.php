<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const CREATED_AT = 'createdTime';
    const UPDATED_AT = 'updatedTime';

    protected $dateFormat = 'U';

    public function createModelService($service, $version = '')
    {
        return app('modelHelper')->createModelService($service, $version);
    }

    public function transformArray($query)
    {
        return app('modelHelper')->transformArray($query);
    }
}
