<?php

declare(strict_types = 1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $router = $this->app->make('router');
        $router->pattern('id', '[0-9]+');

        $this->routes(function () use ($router) {
            $this->getApiRoutes($router);

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    protected function getApiRoutes(Router $router): void
    {
        $files = glob(base_path('routes/api/*'));

        foreach ($files as $file) {
            $router->prefix('api')
                ->middleware('api')
                ->group($file);

        }
    }
}
