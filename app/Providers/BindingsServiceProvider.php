<?php

namespace App\Providers;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class BindingsServiceProvider extends ServiceProvider
{

    private const REPOSITORIES = [
        UserRepositoryContract::class => [
            UserRepository::class,
        ],
    ];


    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        $cacheServices = config('project.general.cache_services');
        foreach (self::REPOSITORIES as $abstract => $repositories) {
            $concrete = $cacheServices ? ($repositories[1] ?? $repositories[0]) : $repositories[0];
            $this->app->bind($abstract, $concrete);
        }
    }
}
