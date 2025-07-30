<?php

namespace Database\Factories;

use App\Models\Accommodation;
use App\Models\AccommodationType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class AccommodationFactory extends Factory
{
    protected $model = Accommodation::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'price_per_night' => $this->faker->randomFloat(),
            'cover_image' =>  (new UploadedFile(path: public_path('assets/images/room1.jpg'),originalName: 'room1.jpg', mimeType: 'image/jpeg')),
            'is_available' => $this->faker->boolean(),
            'description' => $this->faker->text(),
            'gallery' => [],
            'amenities' => [],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'accommodation_type_id' => AccommodationType::factory(),
        ];
    }
}
