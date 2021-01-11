<?php

namespace App\Models\User\Service;

use App\Models\BaseServiceInterface;

interface MenuService extends BaseServiceInterface
{
    public function searchMenu();

    public function getUserMenu($roleData, $menu = []);

    public function filterMenu(array &$array, array $conditions);
}
