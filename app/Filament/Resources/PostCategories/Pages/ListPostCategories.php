<?php

namespace App\Filament\Resources\PostCategories\Pages;

use App\Filament\Resources\PostCategories\PostCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListPostCategories extends ListRecords
{
    protected static string $resource = PostCategoryResource::class;

    protected function getTableHeading(): string|Htmlable|null
    {
        return "Liste des categories";
    }
    protected static ?string $title = "Liste des categories";
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label("Creer une categorie"),
        ];
    }
}
