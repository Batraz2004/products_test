<?php

namespace App\Providers;

use App\Services\ProductService\ProductServiceImplementation\ProductServiceEloquent;
use App\Services\ProductService\ProductServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ProductServiceInterface::class, function (Application $app) {
            return new ProductServiceEloquent();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function provides(): array
    {
        return [ProductServiceInterface::class];
    }
}
