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
        try {
            return response()->json([
                'groupInfo' => $this->getGroupService()->getGroup($id),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $this->getGroupService()->deleteGroup($id);
            return response()->json([
                'message' => '删除成功',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function search(Request $request)
    {
        $param = $request->post();
        try {
            list($total, $list) = $this->getGroupService()->listGroup($param);
            return response()->json([
                'total' => $total,
                'groupList' => $list,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function create(Request $request)
    {
        $param = $request->post();
        try {
            $this->getGroupService()->createGroup($param);
            return response()->json([
                'message' => '创建成功',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function update($id, Request $request)
    {
        $param = $request->all();
        try {
            $this->getGroupService()->updateGroup($id, $param);
            return response()->json([
                'message' => '修改成功',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function getGroupService(): GroupService
    {
        return $this->getService('User:GroupService');
    }
}
