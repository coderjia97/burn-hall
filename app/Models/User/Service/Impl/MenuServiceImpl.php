<?php

namespace App\Models\User\Service\Impl;

use App\Models\BaseService;
use App\Models\User\Service\MenuService;
use App\Toolkit\ArrayTools;
use Symfony\Component\Yaml\Yaml;

class MenuServiceImpl extends BaseService implements MenuService
{
    public function searchMenu()
    {
        return Yaml::parseFile(config_path() . '/menu.yaml');
    }

    public function getUserMenu($roleData, $menu = [])
    {
        if(empty($menu))
        {
            $menu = self::searchMenu();
        }
        if(!is_array($roleData))
        {
            $roleData = explode(",",$roleData);
        }

        return self::filterMenu($menu,$roleData);
    }

    public function filterMenu(array &$array, array $conditions)
    {
        foreach ($array as $key => &$value) {
            if (in_array($value['name'], $conditions)) {
                if (!empty($value['children'])) {
                    $data[] = self::filterMenu($value['children'], $conditions);
                }
            } else {
                unset($array[$key]);
            }
        }

        return $array;
    }
}
