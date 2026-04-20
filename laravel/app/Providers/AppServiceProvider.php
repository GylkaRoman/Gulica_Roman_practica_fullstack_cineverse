<?php

namespace App\Providers;

use App\Repositories\Impl\HallRepository;
use App\Repositories\Impl\MovieRepository;
use App\Repositories\Interfaces\HallRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Services\Impl\HallService;
use App\Services\Impl\MovieService;
use App\Services\Interfaces\HallServiceInterface;
use App\Services\Interfaces\MovieServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
        $this->app->bind(MovieServiceInterface::class, MovieService::class);
        $this->app->bind(HallRepositoryInterface::class, HallRepository::class);
        $this->app->bind(HallServiceInterface::class, HallService::class);
    }

    public function boot(): void
    {
        //
    }
}
