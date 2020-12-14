<?php
/**
 * Sunny 2020/12/14 下午4:56
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Extend\ApiFirewall;

use Illuminate\Http\Request;

class Test implements Firewall
{
    public function handle(Request $request)
    {
        resolve('user')->setUser([
            'id' => '111',
        ]);

        return true;
    }
}
