<?php

namespace App\Providers;

use App\Helper\ModelHelper;
use Illuminate\Support\ServiceProvider;

class HelperProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('modelHelper', ModelHelper::class);
    }
}
