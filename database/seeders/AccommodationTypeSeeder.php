<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class AccommodationTypeSeeder extends Seeder
{
    public function run(): void
    {
        //seed the accommodation types
        $accommodationTypes = config('project.accommodation_types');

        foreach ($accommodationTypes as $accommodationType) {
            $accommodationTypeModel = \App\Models\AccommodationType::updateOrCreate([
                'slug' => str($accommodationType['name'])->slug(),
            ], [
                'name' => $accommodationType['name'],
                'description' => $accommodationType['description'],
                'price_per_night' => $accommodationType['price_per_night'],
                'is_available' => $accommodationType['is_available']??true,
            ]);

            $accommodationTypeModel->services()->sync(Service::pluck('id'));
        }
    }
}
