<?php

declare(strict_types=1);

namespace App\Filament\Resources\Accommodations\Pages;

use App\Filament\Resources\Accommodations\AccommodationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

final class ListAccommodations extends ListRecords
{
    protected static string $resource = AccommodationResource::class;

    public function getTabs(): array
    {
        $tabs = ['Tout' => Tab::make()];
        foreach (config('project.accommodation_types') as $accommodationType) {
            $tabs[$accommodationType['name']] = Tab::make()
                ->badge(fn() => $this->getTabBadge($accommodationType['name']))
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('accommodationType',
                    fn (Builder $query) => $query->where('name', $accommodationType['name']))
                );
        }

        return $tabs;
    }
    protected function getTabBadge(string $accommodationTypeName): int
    {
        return self::getResource()::getEloquentQuery()->whereHas('accommodationType', fn (Builder $query) => $query->where('name', $accommodationTypeName))->count();
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
