<?php

namespace App\Models\User\Service\Impl;

use App\Models\BaseService;
use App\Models\User\Service\MenuService;
use Symfony\Component\Yaml\Yaml;

class MenuServiceImpl extends BaseService implements MenuService
{
    public function listMenu()
    {
        return Yaml::parseFile(config_path().'/menu.yaml');
    }
}
