<?php

namespace App\Providers;

use App\Services\ImageProcessingService;
use Illuminate\Support\ServiceProvider;

class ImageProcessingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ImageProcessingService::class, function ($app) {
            return new ImageProcessingService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
