<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Contracts\Repositories\CountryRepositoryContract;
use App\Contracts\Repositories\TeamRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Repositories\CountryRepository;
use App\Repositories\TeamRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class BindingsServiceProvider extends ServiceProvider
{

    private const REPOSITORIES = [
        UserRepositoryContract::class    => [
            UserRepository::class,
        ],
        TeamRepositoryContract::class    => [
            TeamRepository::class,
        ],
        CountryRepositoryContract::class => [
            CountryRepository::class,
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
