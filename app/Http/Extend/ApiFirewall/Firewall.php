<?php

namespace App\Http\Extend\ApiFirewall;

use Illuminate\Http\Request;

interface Firewall
{
    public function handle(Request $request);
}

