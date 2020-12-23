<?php


namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Controller;
use App\Models\User\Service\MenuService;

class MenuController extends Controller
{
    public function search()
    {
        try {
            return response()->json([
                'menuInfo' => $this->getMenuService()->listMenu(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function getMenuService(): MenuService
    {
        return $this->getService('User:MenuService');
    }
}
