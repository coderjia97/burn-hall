<?php

namespace App\Http\Controllers\Api\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User\Service\MenuService;
use App\Models\User\Service\UserService;

class MenuController extends Controller
{
    public function get()
    {
        $guid = $this->getCurrentUser()->getGuid();
        return $this->getUserService()->getUserJurisdiction($guid);
    }

    public function search()
    {
        return $this->getMenuService()->searchMenu();
    }

    private function getMenuService(): MenuService
    {
        return $this->getService('User:Menu');
    }

    private function getUserService(): UserService
    {
        return $this->getService('User:User');
    }
}
