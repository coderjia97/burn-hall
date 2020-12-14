<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        \InvalidArgumentException::class,
        \App\Exceptions\Middleware\AuthException::class,
    ];

    public function render($request, Throwable $exception)
    {
        if (!env('APP_DEBUG', false)) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode() <= 0 ? 500 : $exception->getCode());
        }

        return parent::render($request, $exception);
    }
}
