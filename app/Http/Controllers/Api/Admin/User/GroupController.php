<?php

namespace App\Http\Controllers\Api\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User\Service\GroupService;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function get($id)
    {
        $groupInfo = $this->getGroupService()->getGroup($id);

        return response()->json($groupInfo);
    }

    public function delete($id)
    {
        return $this->getGroupService()->deleteGroup($id);
    }

    public function search(Request $request)
    {
        $conditions = $request->all();

        return $this->getGroupService()->searchByPagination($conditions, []);
    }

    public function create(Request $request)
    {
        $data = $request->all();

        return $this->getGroupService()->createGroup($data);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        return $this->getGroupService()->updateGroup($id, $data);
    }

    private function getGroupService(): GroupService
    {
        return $this->getService('User:GroupService');
    }
}
