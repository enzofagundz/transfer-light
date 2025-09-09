<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SystemServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Services\Interfaces\AuthorizeServiceInterface::class,
            \App\Services\AuthorizeService::class
        );

        $this->app->bind(
            \App\Services\Interfaces\UserServiceInterface::class,
            \App\Services\UserService::class
        );

        $this->app->bind(
            \App\Services\Interfaces\TransactionServiceInterface::class,
            \App\Services\TransactionService::class
        );

        $this->app->bind(
            \App\Services\Interfaces\TransferServiceInterface::class,
            \App\Services\TransferService::class
        );

        $this->app->bind(
            \App\Services\Interfaces\NotificationServiceInterface::class,
            \App\Services\NotificationService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
