<?php

namespace App\Providers;

use App\Repositories\Impl\MovieRepository;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Services\Impl\MovieService;
use App\Services\Interfaces\MovieServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
        $this->app->bind(MovieServiceInterface::class, MovieService::class);
    }

    public function boot(): void
    {
        //
    }
}
