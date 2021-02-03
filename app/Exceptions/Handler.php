<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
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

        return new JsonResponse(
            $this->convertExceptionToArray($exception),
            $exception->getCode() <= 0 ? 500 : $exception->getCode(),
            [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
        return parent::render($request, $exception);
    }
}
