<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Enums\AccommodationTypeEnum;
use App\Models\Accommodation;
use App\Models\AccommodationType;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

final class AccommodationSeeder extends Seeder
{
    public function run(): void
    {
        // Create accommodations
        foreach (AccommodationType::all()  as  $accommodationType) {
            $this->createAccommodation(accommodationType: $accommodationType);
        }
    }

    /**
     * @return array{path: string, name: string, mimetype: string}
     */
    private function getUploadedFilePathForAccommodationType(string $accommodationType): array
    {
        return match ($accommodationType) {
            AccommodationTypeEnum::APPARTEMENT->value => ['path' => public_path('assets/images/room1.jpg'), 'name' => 'room1.jpg', 'mimetype' => 'image/jpeg'],
            AccommodationTypeEnum::CHAMBRE->value => ['path' => public_path('assets/images/room2.jpg'), 'name' => 'room2.jpg', 'mimetype' => 'image/jpeg'],
            AccommodationTypeEnum::STUDIO->value => ['path' => public_path('assets/images/room3.jpg'), 'name' => 'room3.jpg', 'mimetype' => 'image/jpeg'],
            default => ['path' => public_path('assets/images/fallback.png'), 'name' => 'fallback.png', 'mimetype' => 'image/png'],
        };
    }

    private function createAccommodation(AccommodationType $accommodationType): void
    {
        foreach (range(1, 2) as $index) {
            $accommodation = Accommodation::firstWhere('code', $accommodationType->name."#$index");
            if ($accommodation !== null) {
                continue;
            }
            $path = $this->getUploadedFilePathForAccommodationType($accommodationType->name);
            $uploadedFile = new UploadedFile(path: $path['path'], originalName: $path['name'], mimeType: $path['mimetype']);
            $coverImagePath = $uploadedFile->storeAs('accommodations', $path['name'], ['disk' => 'public']);
            Accommodation::create([
                'code' => $accommodationType->name."#$index",
                'amenities' => [],
                'gallery' => [],
                'cover_image' => $coverImagePath,
                'description' => fake()->text(),
                'accommodation_type_id' => $accommodationType->id,
                'is_available' => true,
            ]);
        }
    }
}
