<?php

namespace App\Models\User\Service\Impl;

use App\Models\BaseService;
use App\Models\User\Service\MenuService;
use Symfony\Component\Yaml\Yaml;

class MenuServiceImpl extends BaseService implements MenuService
{
    public function searchMenu()
    {
        return Yaml::parseFile(config_path() . '/menu.yaml');
    }

    public function getUserMenu($roleData, $menu = [])
    {
        if (empty($menu)) {
            $menu = $this->searchMenu();
        }
        if (!is_array($roleData)) {
            $roleData = explode(',', $roleData);
        }

        return $this->filterMenu($menu, $roleData);
    }

    public function filterMenu(array &$array, array $conditions)
    {
        foreach ($array as $key => &$value) {
            if (in_array($value['name'], $conditions)) {
                if (!empty($value['children'])) {
                    $data[] = $this->filterMenu($value['children'], $conditions);
                }
            } else {
                unset($array[$key]);
            }
        }

        return array_values($array);
    }
}
