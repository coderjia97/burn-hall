<?php
/**
 * Sunny 2020/12/14 下午4:56
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Extend\ApiFirewall;

use App\Models\User\Service\UserService;
use Illuminate\Http\Request;

class Jwt implements Firewall
{
    public function handle(Request $request)
    {
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

        $user = $this->getUserModel()->getUserByGuid($jwt['guid']);
        $menu = $this->getUserModel()->getUserJurisdiction($jwt['guid']);
        resolve('user')->setUser(array_merge($user, [
            'source' => $jwt['source'],
            'menu' => $menu,
        ]));

        return true;
    }

    private function getJwtModel(): \App\Models\Jwt\Service\JwtService
    {
        return app('modelHelper')->getService('Jwt:Jwt');
    }

    private function getUserModel(): UserService
    {
        return app('modelHelper')->getService('User:User');
    }
}
