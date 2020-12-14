<?php
/**
 * Sunny 2020/12/14 下午4:42
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Providers;

use App\Models\User\Provider\CurrentUserProvider;
use Illuminate\Support\ServiceProvider;

class UserProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('user', CurrentUserProvider::class);
    }
}
