<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Api
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
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

        $info = $request->method() . '  ' . $request->ip() . '  ' . $request->fullUrl() . PHP_EOL;
        $info .= 'params:' . json_encode($request->all()) . PHP_EOL;
        $info .= 'time:' . (microtime(true) - $startTime) . PHP_EOL;
        $info .= 'header:' . json_encode($request->header()) . PHP_EOL;
        $info .= 'content:' . $response->getContent() . PHP_EOL;
        $info .= str_repeat('----------', 50) . PHP_EOL;
        Log::channel('api_info_log')->info($info);

        if($response->getStatusCode() != 200){
            Log::channel('api_error_log')->error($info);
        }

        return $response;
    }
}
