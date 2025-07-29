<?php
// tests/Unit/ProductRepositoryTest.php
use App\Domain\Contracts\ProductRepositoryContract;
use App\Models\Post;
use App\Models\Product;

it('returns at most the required number of recommended products', function () {
    /** @var ProductRepositoryContract $repo */
    $repo = app(ProductRepositoryContract::class);

    /** @var Post $post */
    $post = Post::factory()->published()->create();

    // crée 5 produits publiés dans la même catégorie
    Product::factory()->published()->count(5)->create([
        'category_id' => 1,
    ]);

    $recommended = $repo->findRecommendedForPost($post, 2);

    expect($recommended)->toHaveCount(2);
});
