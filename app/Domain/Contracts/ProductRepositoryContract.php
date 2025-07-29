<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductRepositoryContract
{
    /** @return LengthAwarePaginator<Product> */
    public function paginate(int $perPage = 12): LengthAwarePaginator;

    public function findBySlug(string $slug): ?Product;

    /** @return Collection<int,Product> */
    public function findRecommendedForPost(Post $post, int $limit = 2): Collection;
}
