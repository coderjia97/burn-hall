<?php
/**
 * Sunny 2020/12/14 下午1:51
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

        return true;
    }

    private function getJwtModel(): \App\Models\Jwt\Service\JwtService
    {
        return app('modelHelper')->getService('Jwt:JwtService');
    }
}
