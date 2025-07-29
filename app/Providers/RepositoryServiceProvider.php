<?php
// app/Providers/RepositoryServiceProvider.php
declare(strict_types=1);

namespace App\Providers;

use App\Domain\Contracts\ProductRepositoryContract;
use App\Domain\Contracts\PostRepositoryContract;
use App\Infrastructure\Persistence\Repositories\ProductRepository;
use App\Infrastructure\Persistence\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;

final class RepositoryServiceProvider extends ServiceProvider
{
    public array $singletons = [
        PostRepositoryContract   ::class => PostRepository::class,
        ProductRepositoryContract::class => ProductRepository::class,
    ];
}
