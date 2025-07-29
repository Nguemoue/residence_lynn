<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Number;

class ProductStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected  ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 3;

    protected function getStats(): array
    {
        $startDate = $this->filters['start_date'] ?? null;
        $endDate = $this->filters['end_date'] ?? null;

        $baseQuery = Product::query()
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate));

        $totalProducts = $baseQuery->count();
        $activeProducts = $baseQuery->published()->count();
        $outOfStock = $baseQuery->where('stock_type', 'limited')->where('quantity', 0)->count();

        return [
            Stat::make(__('dashboard.product_stats.total_products'), Number::format($totalProducts))
                ->description(__('dashboard.product_stats.total_products_desc'))
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
            Stat::make(__('dashboard.product_stats.active_products'), Number::format($activeProducts))
                ->description(__('dashboard.product_stats.active_products_desc'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make(__('dashboard.product_stats.out_of_stock'), Number::format($outOfStock))
                ->description(__('dashboard.product_stats.out_of_stock_desc'))
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
