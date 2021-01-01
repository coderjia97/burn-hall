<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get($guid)
    {
        $userInfo = $this->getUserService()->getUserByGuid($guid);

        return response()->json($userInfo);
    }

    public function search(Request $request)
    {
        $conditions = $request->all();

        return $this->getUserService()->searchByPagination($conditions, []);
    }

    public function create(Request $request)
    {
        $data = $request->all();

        return $this->getUserService()->createUser($data);
    }

    public function update($guid, Request $request)
    {
        $data = $request->all();

        return $this->getUserService()->updateUser($guid, $data);
    }

    public function modify($guid)
    {
        return $this->getUserService()->modify($guid);
    }

    public function delete($guid)
    {
        return $this->getUserService()->deleteUser($guid);
    }

    private function getUserService(): UserService
    {
        return $this->getService('User:UserService');
    }
}
