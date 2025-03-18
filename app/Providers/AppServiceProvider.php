<?php

namespace App\Providers;

use App\Services\ContactService;
// use App\Services\ContactServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\FileStorageServiceInterface;
use App\Services\FileStorageService;
use App\Services\Contracts\ContactRepositoryInterface;
use App\Repositories\ContactRepository;
use App\Services\Contracts\ContactServiceInterface;
// use App\Services\ContactService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //$this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        // $this->app->bind(ContactServiceInterface::class, ContactService::class);
        $this->app->bind(ContactServiceInterface::class, ContactService::class);
        $this->app->bind(FileStorageServiceInterface::class, FileStorageService::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
