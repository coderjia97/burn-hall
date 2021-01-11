<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\User;

use App\Http\Controllers\Api\Annotation\ResponseFilter;
use App\Http\Controllers\Controller;
use App\Models\User\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @ResponseFilter(class="\App\Http\Controllers\Api\Admin\User\Filter\UserFilter", mode="simple")
     */
    public function get($guid)
    {
        $userInfo = $this->getUserService()->getUserByGuid($guid);

        return response()->json($userInfo);
    }

    /**
     * @ResponseFilter(class="\App\Http\Controllers\Api\Admin\User\Filter\UserFilter", mode="simple")
     */
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

    public function update(Request $request, $guid)
    {
        $data = $request->all();

        return $this->getUserService()->updateUser($guid, $data);
    }

    public function modify(Request $request, $guid)
    {
        $value = $request->get('value');
        $type = $request->get('type');

        return $this->getUserService()->modify($guid, $type, !$value);
    }

    public function delete($guid)
    {
        return $this->getUserService()->deleteUser($guid);
    }

    private function getUserService(): UserService
    {
        return $this->getService('User:User');
    }
}
