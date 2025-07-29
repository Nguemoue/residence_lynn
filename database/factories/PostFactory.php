<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'post_category_id' => PostCategory::factory(),
            'title'            => $title,
            'slug'             => Str::slug($title),
            'cover_image'      => "https://placehold.net/default.png",
            'excerpt'          => $this->faker->sentence(),
            'content'          => $this->faker->paragraphs(5, true),
            'is_published'     => true,
            'published_at'     => now(),
        ];
    }
    // … haut du fichier inchangé …
    public function configure(): static
    {
        return $this->afterCreating(function (Post $post) {
            $tagIds = \App\Models\Tag::inRandomOrder()->take(random_int(1,4))->pluck('id');
            $post->tags()->sync($tagIds);
        });
    }

    public function published(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => true,
            'published_at' => now()
        ]);
    }

}
