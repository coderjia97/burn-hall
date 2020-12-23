<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User\Service\MenuService;

class MenuController extends Controller
{
    public function search()
    {
        return response()->json($this->getMenuService()->listMenu());
    }

    private function getMenuService(): MenuService
    {
        return $this->getService('User:MenuService');
    }
}
