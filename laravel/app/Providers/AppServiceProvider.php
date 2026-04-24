<?php

namespace App\Providers;

use App\Repositories\Impl\AuthRepository;
use App\Repositories\Impl\BookingRepository;
use App\Repositories\Impl\HallRepository;
use App\Repositories\Impl\MovieRepository;
use App\Repositories\Impl\PriceRepository;
use App\Repositories\Impl\SessionRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\HallRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Repositories\Interfaces\PriceRepositoryInterface;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use App\Services\Impl\AuthService;
use App\Services\Impl\BookingService;
use App\Services\Impl\HallService;
use App\Services\Impl\MovieService;
use App\Services\Impl\PriceService;
use App\Services\Impl\SessionService;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\BookingServiceInterface;
use App\Services\Interfaces\HallServiceInterface;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\PriceServiceInterface;
use App\Services\Interfaces\SessionServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
        $this->app->bind(MovieServiceInterface::class, MovieService::class);
        $this->app->bind(HallRepositoryInterface::class, HallRepository::class);
        $this->app->bind(HallServiceInterface::class, HallService::class);
        $this->app->bind(SessionRepositoryInterface::class, SessionRepository::class);
        $this->app->bind(SessionServiceInterface::class, SessionService::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(BookingServiceInterface::class, BookingService::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(PriceRepositoryInterface::class, PriceRepository::class);
        $this->app->bind(PriceServiceInterface::class, PriceService::class);
        }

    public function boot(): void
    {
        //
    }
}
