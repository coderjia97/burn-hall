<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get($id)
    {
        $userInfo = $this->getUserService()->getUser($id);

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

    public function update($id,Request $request)
    {
        $data = $request->all();

        return $this->getUserService()->updateUser($id, $data);
    }

    public function modify($id)
    {
        return $this->getUserService()->modify($id);
    }

    public function delete($id)
    {
        return $this->getUserService()->deleteUser($id);
    }

    private function getUserService(): UserService
    {
        return $this->getService('User:UserService');
    }
}
