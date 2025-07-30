<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Faq;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Subscriber;
use App\Models\Tag;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if (Tag::count() === 0) {
            \App\Models\Tag::factory()->count(5)->create();
        }

        if (PostCategory::count() === 0) {
            PostCategory::factory(3)->create()->each(
                fn ($c) => Post::factory(1)->create([
                    'post_category_id' => $c->id,
                ])
            );
        }
        if (Faq::count() === 0){
            Faq::factory(3)->create();
        }

        if (Subscriber::count() === 0) {
            Subscriber::factory(1)->create();
        }
        //
        Admin::updateOrCreate([
            'email'=>'admin@gmail.com'
        ],[
            'password'=>bcrypt('password'),
            'name'=>"Admin"
        ]);

        //seed accomodation type seeder
        $this->call(ServiceSeeder::class);
        $this->call(TestimonialsSeeder::class);
        // must be came after service seeder
        $this->call(AccommodationTypeSeeder::class);
        // must be came after accommodation type seeder
        $this->call(AccommodationSeeder::class);

    }
}
