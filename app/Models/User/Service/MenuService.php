<?php

namespace App\Models\User\Service;

use App\Models\BaseServiceInterface;

interface MenuService extends BaseServiceInterface
{
    public function listMenu();
}
