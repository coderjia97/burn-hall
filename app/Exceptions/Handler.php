<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if (!env('APP_DEBUG', false)) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }

        return parent::render($request, $exception);
    }
}
