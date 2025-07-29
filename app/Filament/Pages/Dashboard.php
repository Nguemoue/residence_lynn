<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ContactStats;
use App\Filament\Widgets\OrderStats;
use App\Filament\Widgets\PostStats;
use App\Filament\Widgets\ProductStats;
use App\Filament\Widgets\RecentOrdersTable;
use App\Filament\Widgets\TagStats;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;


    public function filtersForm(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('dashboard.filters'))
                ->schema([
                    DatePicker::make('start_date')
                        ->label(__('dashboard.start_date'))
                        ->native(false),
                    DatePicker::make('end_date')
                        ->label(__('dashboard.end_date'))
                        ->native(false),
                ])
                ->columnSpanFull()
                ->columns(2),
        ]);
    }

    public function getWidgets(): array
    {
        return [
            //ProductStats::class,
            PostStats::class,
            //OrderStats::class,
            ContactStats::class,
            TagStats::class,
            //RecentOrdersTable::class,
        ];
    }

    public function getColumns(): int|array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'xl' => 3,
        ];
    }



    protected function getHeaderActions(): array
    {
        return [];
    }
}
