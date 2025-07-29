<?php
// app/Infrastructure/Persistence/Repositories/PostRepository.php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Contracts\PostRepositoryContract;
use App\Models\Post;
use Illuminate\Support\Collection;

final class PostRepository implements PostRepositoryContract
{
    public function findPublishedBySlug(string $slug): ?Post
    {
        return Post::with(['author', 'category', 'tags'])
            ->published()
            ->where('slug', $slug)
            ->first();
    }

    public function related(Post $post, int $limit = 3): Collection
    {
        return Post::published()
            ->where('id', '!=', $post->id)
            ->where('post_category_id', $post->post_category_id)
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function recent(int $limit = 3): Collection
    {
        return Post::published()
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }
}
