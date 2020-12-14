<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\User;

use App\Exceptions\Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function create()
    {
        return response()->json([
            'message' => '获取成功',
            'data' => [
                'token' => $this->getJwtModel()->generateAssetsTokenByGuid('aaa'),
            ]
        ]);
    }

    public function update(Request $request)
    {
        $token = $request->get('token', '');
        if ($token === '') {
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
        return $this->getService('Jwt:JwtService');
    }
}
