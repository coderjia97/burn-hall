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
use App\Models\Jwt\Service\JwtService;
use App\Models\User\Service\RefreshTokenService;
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
        return $this->getUserService()->getUserJurisdiction($guid);
    }

    public function update(Request $request)
    {
        $token = $request->post('token', '');

        $token = $this->getRefreshTokenModel()->getToken($token);
        if (empty($token)) {
            throw new Exception('500登陆信息过期');
        }
        $user = $this->getUserService()->get($token['userId']);

        return ['token' => $this->getJwtModel()->generateAssetsTokenByGuid($user['guid'])];
    }

    private function getJwtModel(): JwtService
    {
        return $this->getService('Jwt:Jwt');
    }

    private function getUserService(): UserService
    {
        return $this->getService('User:User');
    }

    private function getRefreshTokenModel(): RefreshTokenService
    {
        return $this->getService('User:RefreshToken');
    }
}
