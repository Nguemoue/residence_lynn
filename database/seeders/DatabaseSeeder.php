<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\StockTypeEnum;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
// 30 tags
        \App\Models\Tag::factory()->count(5)->create();
        // Catégories & Produits
        Category::factory(2)->create()->each(
            fn (Category $cat) => Product::factory(1)->create(['category_id' => $cat->id,'stock_type' => StockTypeEnum::UNLIMITED])
        );

        // Blog
        PostCategory::factory(3)->create()->each(
            fn ($c) => Post::factory(1)->create([
                'post_category_id' => $c->id,
            ])
        );

        // FAQ, Newsletter
        Faq::factory(3)->create();
        Subscriber::factory(1)->create();
        Admin::updateOrCreate([
            'email'=>'admin@gmail.com'
        ],[
            'password'=>bcrypt('password'),
            'name'=>"Admin"
        ]);
    }
}
