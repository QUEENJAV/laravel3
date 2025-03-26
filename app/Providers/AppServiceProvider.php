<?php

namespace App\Providers;

use App\Services\ContactService;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\FileStorageServiceInterface;
use App\Services\FileStorageService;
use App\Services\Contracts\ContactRepositoryInterface;
use App\Repositories\ContactRepository;
use App\Services\Contracts\ContactServiceInterface;

class AppServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
        $this->app->bind(ContactServiceInterface::class, ContactService::class);
        $this->app->bind(FileStorageServiceInterface::class, FileStorageService::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
