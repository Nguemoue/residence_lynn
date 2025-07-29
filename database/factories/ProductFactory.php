<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        return [
            'category_id'       => Category::factory(),
            'name'              => Str::title($name),
            'slug'              => Str::slug($name),
            'short_description' => $this->faker->sentence(),
            'description'       => $this->faker->paragraph(),
            'price'             => $this->faker->randomFloat(2, 10, 120),
            'discount_price'    => $this->faker->boolean(40) ? $this->faker->randomFloat(2, 5, 90) : null,
            'cover_image'       => "https://placehold.net/default.png",
            'gallery'           => ["https://placehold.net/default.png","https://placehold.net/default.png"],
            'is_active'         => true,
        ];
    }

    public function published(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true
        ]);
    }
}
