<?php

namespace App\Providers;

use App\Events\ProductCreatedEvent;
use App\Listeners\SendProductCreatedEmailListener;
use App\Models\Product;
use App\Observers\ProductObserver;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Service\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->singleton('product-service', function ($app) {
            return new ProductService($app->make(ProductRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);
    }

    protected $listen = [
        ProductCreatedEvent::class =>
        [
            SendProductCreatedEmailListener::class
        ],
    ];
}
