<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domain\Contracts\ProductRepositoryContract;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //$this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCurrency();
    }

    private function configureCurrency()
    {
        Number::useCurrency(currency: "XAF");
        Number::useLocale("fr_FR");
    }
}
