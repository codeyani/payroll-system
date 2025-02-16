<?php

namespace App\Providers;

use App\Services\BankAccountService;
use App\Services\BankChangeRequestService;
use App\Services\Interfaces\BankAccountServiceInterface;
use App\Services\Interfaces\BankChangeRequestServiceInterface;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BankChangeRequestServiceInterface::class, BankChangeRequestService::class);
        $this->app->bind(BankAccountServiceInterface::class, BankAccountService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
