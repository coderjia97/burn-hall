<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\User;

use App\Exceptions\Exception;
use App\Http\Controllers\Api\Annotation\ResponseFilter;
use App\Http\Controllers\Controller;
use App\Models\User\Service\UserService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @ResponseFilter(class="\App\Http\Controllers\Api\Admin\User\Filter\LoginFilter", mode="simple")
     */
    public function create(Request $request)
    {
        $conditions = $request->all();

        return $this->getUserService()->loginUser($conditions);
    }

    public function get($guid)
    {
        return $this->getUserService()->getUserjurisdiction($guid);
    }

    public function update(Request $request)
    {
        $token = $request->get('token', '');
        if ('' === $token) {
            throw new Exception('403token丢失');
        }

        try {
            $jwt = $this->getJwtModel()->decode($token);
        } catch (\Exception $e) {
            throw new Exception('403token过期或无效');
        }

        return response()->json([
            'message' => '获取成功',
            'data' => $this->getJwtModel()->generateAssetsTokenByGuid($jwt['guid']),
        ]);
    }

    private function getJwtModel(): \App\Models\Jwt\Service\JwtService
    {
        return $this->getService('Jwt:Jwt');
    }

    private function getUserService(): UserService
    {
        return $this->getService('User:User');
    }
}
