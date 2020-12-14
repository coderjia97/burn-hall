<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Extend\ApiFirewall;

use Illuminate\Http\Request;

interface Firewall
{
    public function handle(Request $request);
}
