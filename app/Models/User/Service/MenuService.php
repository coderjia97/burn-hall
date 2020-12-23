<?php

namespace App\Models\User\Service;

use App\Models\BaseModel;
use Symfony\Component\Yaml\Yaml;

class MenuService extends BaseModel
{
    public function listMenu()
    {
        return Yaml::parseFile(config_path().'/menu.yaml');
    }
}
