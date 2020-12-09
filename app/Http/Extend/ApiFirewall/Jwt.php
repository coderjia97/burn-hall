<?php

namespace App\Http\Extend\ApiFirewall;

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

        return true;
    }

    private function getJwtModel(): \App\Models\Jwt\Service\Jwt
    {
        return app('modelHelper')->createModelService('Jwt:Jwt');
    }
}
