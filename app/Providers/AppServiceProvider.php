<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\CartRepository;
use App\Repositories\CartRepositoryInterface;
use App\Services\ProductService;
use App\Services\CartService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       // Bind the ProductRepositoryInterface to the ProductRepository implementation
    // This ensures that whenever the interface is requested, Laravel will provide an instance of ProductRepository.
    $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

    // Register ProductService as a singleton in the service container.
    // This means Laravel will create only one instance of ProductService and reuse it wherever needed.
    $this->app->singleton(ProductService::class, function ($app) {
        return new ProductService($app->make(ProductRepositoryInterface::class));
    });


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
