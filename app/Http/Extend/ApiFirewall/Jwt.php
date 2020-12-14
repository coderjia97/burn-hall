<?php
/**
 * Sunny 2020/12/14 下午4:42
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Extend\ApiFirewall;

use Illuminate\Http\Request;

class Jwt implements Firewall
{
    public function handle(Request $request)
    {
        return true;
        if (config('app.apiAccept', '') !== $request->headers->get('accept')) {
            return false;
        }

        if (!$request->headers->get('assetsToken')) {
            return false;
        }

        try {
            $jwt = $this->getJwtModel()->decode($request->headers->get('assetsToken'));
        } catch (\Exception $e) {
            return false;
        }

        if (!$jwt['guid']) {
            return false;
        }

        // todo 完善登录用户信息
        resolve('user')->setUser([
            'id' => '111',
        ]);

        return true;
    }

    private function getJwtModel(): \App\Models\Jwt\Service\JwtService
    {
        return app('modelHelper')->getService('Jwt:JwtService');
    }
}
