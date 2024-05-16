<?php

namespace App\Providers;

use App\Service\GetTemp;
use App\Service\ImageMetadataExtractor;
use Illuminate\Support\ServiceProvider;
use App\Service\Contracts\GetTempInterface;
use App\Service\Contracts\ImageMetadataExtractorInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GetTempInterface::class, GetTemp::class);
        $this->app->bind(ImageMetadataExtractorInterface::class, ImageMetadataExtractor::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
