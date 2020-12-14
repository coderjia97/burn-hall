<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Api
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!empty($request->header('TOKEN'))) {
            //得到userid
            $user_id = '';
        }

        $startTime = microtime(true);
        $response = $next($request);

        $info = $request->method().'  '.$request->ip().'  '.$request->fullUrl().PHP_EOL;
        $info .= 'params:'.json_encode($request->all()).PHP_EOL;
        $info .= 'time:'.(microtime(true) - $startTime).PHP_EOL;
        $info .= 'header:'.json_encode($request->header()).PHP_EOL;
        $info .= 'content:'.$response->getContent().PHP_EOL;
        $info .= str_repeat('----------', 50).PHP_EOL;
        Log::channel('api_info_log')->info($info);

        if (200 != $response->getStatusCode()) {
            Log::channel('api_error_log')->error($info);
        }

        return $response;
    }
}