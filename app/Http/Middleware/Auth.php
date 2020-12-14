<?php
/**
 * Sunny 2020/12/14 下午4:56
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Middleware;

use App\Exceptions\Middleware\AuthException;
use Closure;
use Illuminate\Http\Request;

class Auth
{
    public $whitelist = [
        '/^\/api\/user\/login/',
    ];

    public function handle(Request $request, Closure $next)
    {
        if ($this->checkWhitelists($request->getRequestUri())) {
            foreach (config('apiFirewall') as $firewall) {
                if ((new $firewall())->handle($request)) {
                    return $next($request);
                }
            }
        }

        throw new AuthException(AuthException::TOKEN_EXPIRED);
    }

    private function checkWhitelists($url): bool
    {
        foreach ($this->whitelist as $whitelist) {
            if (preg_match($whitelist, $url)) {
                return false;
            }
        }

        return true;
    }
}
