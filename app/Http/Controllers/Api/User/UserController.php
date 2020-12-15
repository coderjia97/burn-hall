<?php
/**
 * Sunny 2020/12/15 上午9:38
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User\Service\UserService;

class UserController extends Controller
{
    public function get($id): string
    {
        $this->getUserService()->create([
            'name' => 'test1',
            'password' => '123',
            'group' => 0,
        ]);

        return 'get';
    }

    public function search(): string
    {
        return 'search';
    }

    public function create()
    {
        return 'create';
    }

    public function update()
    {
        return 'update';
    }

    public function modify()
    {
        return 'modify';
    }

    public function delete()
    {
        return 'delete';
    }

    private function getUserService(): UserService
    {
        return $this->getService('User:UserService');
    }
}
