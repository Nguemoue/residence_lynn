<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Contracts\ProductRepositoryContract;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryContract
{
    public function all(): Collection
    {
        return Product::all();
    }

    public function findBySlug(string $slug): ?Product
    {
        return Product::where('slug', $slug)->first();
    }

    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    public function paginate(int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()->paginate($perPage);
    }

    /**
     * Retourne des produits « recommandés » pour un article de blog.
     *
     * Règles :
     * 1. On privilégie les produits qui partagent (au moins) un tag avec le post.
     * 2. S’il n’y a pas assez de résultats, on complète avec des produits de la
     *    même catégorie que l’article (si renseignée) puis, en dernier recours,
     *    avec des produits récemment publiés.
     *
     * @param  Post  $post   L’article de référence
     * @param  int   $limit  Nombre de produits maximum à renvoyer
     * @return Collection<Product>
     */
    public function findRecommendedForPost(Post $post, int $limit = 3): Collection
    {
        /** @var \Illuminate\Database\Eloquent\Builder<Product> $query */
        $query = Product::query()->published();  // ➜ scopePublished() ajouté précédemment

        /* -----------------------------
         | (1) – Filtre sur les tags
         * ----------------------------*/
        $tagIds = $post->tags->pluck('id');

        if ($tagIds->isNotEmpty()) {
            $query->whereHas('tags', fn ($q) => $q->whereIn('tags.id', $tagIds));
        }

        $products = $query
            ->inRandomOrder()
            ->limit($limit)
            ->get();

        /* -----------------------------
         | (2) – Complément par catégorie
         * ----------------------------*/
        if ($products->count() < $limit && $post->post_category_id) {
            $remaining = $limit - $products->count();

            $more = Product::published()
                ->where('category_id', $post->post_category_id)
                ->whereNotIn('id', $products->pluck('id'))
                ->inRandomOrder()
                ->limit($remaining)
                ->get();

            $products = $products->merge($more);
        }

        /* -----------------------------
         | (3) – Complément « fallback »
         * ----------------------------*/
        if ($products->count() < $limit) {
            $remaining = $limit - $products->count();

            $fallback = Product::published()
                ->whereNotIn('id', $products->pluck('id'))
                ->latest()
                ->limit($remaining)
                ->get();

            $products = $products->merge($fallback);
        }

        return $products;
    }

}
