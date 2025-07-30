<?php

namespace App\Filament\Dashboard\Resources\Testimonials\Pages;

use App\Filament\Dashboard\Resources\Testimonials\TestimonialResource;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;

class ListTestimonials extends ListRecords
{
    protected static string $resource = TestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->mutateDataUsing(function (array $data): array {
                $data['user_id'] = Filament::auth()->id();

                return $data;
            }),
        ];
    }
}
