<?php
/**
 * Sunny 2020/12/23 下午2:46
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Controllers\Api\Admin\System;

use App\Http\Controllers\Controller;

class VerificationCodeController extends Controller
{
    public function search($config = 'flat')
    {
        return response()->json(app('captcha')->create($config, true));
    }
}
