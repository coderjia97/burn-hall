<?php

namespace App\Http\Controllers\Api\Admin\User;

use App\Http\Controllers\Api\Annotation\ResponseFilter;
use App\Http\Controllers\Controller;
use App\Models\User\Service\GroupService;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function get($id)
    {
        $groupInfo = $this->getGroupService()->get($id);

        return response()->json($groupInfo);
    }

    public function delete($id)
    {
        return $this->getGroupService()->deleteGroup($id);
    }

    /**
     * @ResponseFilter(class="\App\Http\Controllers\Api\Admin\User\Filter\GroupFilter", mode="simple")
     */
    public function search(Request $request)
    {
        $conditions = $request->get('conditions', []);

        return $this->getGroupService()->searchByPagination($conditions, ['createTime' => 'desc']);
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
        return $this->getService('User:Group');
    }
}
