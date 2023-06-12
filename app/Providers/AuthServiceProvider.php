<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Contracts\AuthUserContract;
use App\Contracts\Models\UserContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        $this->app->singleton(AuthUserContract::class, static function (Application $app): null|UserContract {
            $auth = $app['auth'];

            return $auth->user();
        });
    }
}
