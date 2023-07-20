<?php

namespace App\Providers;

use App\Contracts\LoggerInterface;
use App\Contracts\RabbitMQServiceInterface;
use App\Services\LoggerService;
use App\Services\RabbitMQService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoggerInterface::class, LoggerService::class);
        $this->app->bind(RabbitMQServiceInterface::class, RabbitMQService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
