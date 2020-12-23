<?php


namespace App\Http\Controllers\Api\User;


use App\Exceptions\Exception;
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
        $this->getGroupService()->deleteGroup($id);
        
        return response()->json([
            'message' => '删除成功'
        ]);
    }

    public function search(Request $request)
    {
        $param = $request->post();
        list($count,$groupList) = $this->getGroupService()->listGroup($param);
        
        return response()->json([
            'total' => $count,
            'groupList' => $groupList
        ]);
    }

    public function create(Request $request)
    {
        $param = $request->post();
        $this->getGroupService()->createGroup($param);
        
        return response()->json([
            'message' => '创建成功'
        ]);
    }

    public function update($id, Request $request)
    {
        $param = $request->all();
        $this->getGroupService()->updateGroup($id, $param);
        
        return response()->json([
            'message' => '修改成功'
        ]);
    }

    private function getGroupService(): GroupService
    {
        return $this->getService('User:GroupService');
    }
}
