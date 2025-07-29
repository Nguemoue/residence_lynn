<?php

namespace App\Filament\Widgets;

use App\Domain\Enums\OrderStatusEnum;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Number;

class OrderStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected  ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 3;

    protected function getStats(): array
    {
        $startDate = $this->filters['start_date'] ?? null;
        $endDate = $this->filters['end_date'] ?? null;

        $baseQuery = Order::query()
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate));

        $totalOrders = $baseQuery->count();
        $totalRevenue = $baseQuery->sum('total');
        $pendingOrders = $baseQuery->where('status', OrderStatusEnum::RECEIVED)->count();

        return [
            Stat::make(__('dashboard.order_stats.total_orders'), Number::format($totalOrders))
                ->description(__('dashboard.order_stats.total_orders_desc'))
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
            Stat::make(__('dashboard.order_stats.total_revenue'), Number::currency($totalRevenue, 'EUR'))
                ->description(__('dashboard.order_stats.total_revenue_desc'))
                ->descriptionIcon('heroicon-m-currency-euro')
                ->color('success'),
            Stat::make(__('dashboard.order_stats.pending_orders'), Number::format($pendingOrders))
                ->description(__('dashboard.order_stats.pending_orders_desc'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
