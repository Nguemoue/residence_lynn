<?php
// app/Domain/Contracts/PostRepositoryContract.php
declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PostRepositoryContract
{
    public function findPublishedBySlug(string $slug): ?Post;

    /** @return Collection<int,Post> */
    public function related(Post $post, int $limit = 3): Collection;

    /** @return Collection<int,Post> */
    public function recent(int $limit = 3): Collection;

}
