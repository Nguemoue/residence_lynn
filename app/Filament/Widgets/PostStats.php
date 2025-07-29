<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Number;

class PostStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected  ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 3;

    protected function getStats(): array
    {
        $startDate = $this->filters['start_date'] ?? null;
        $endDate = $this->filters['end_date'] ?? null;

        $baseQuery = Post::query()
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate));

        $totalPosts = $baseQuery->count();
        $publishedPosts = $baseQuery->published()->count();
        $averageReadTime = $baseQuery->get()->avg('read_time') ?? 0;

        return [
            Stat::make(__('dashboard.post_stats.total_posts'), Number::format($totalPosts))
                ->description(__('dashboard.post_stats.total_posts_desc'))
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            Stat::make(__('dashboard.post_stats.published_posts'), Number::format($publishedPosts))
                ->description(__('dashboard.post_stats.published_posts_desc'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make(__('dashboard.post_stats.average_read_time'), round($averageReadTime, 1) . ' min')
                ->description(__('dashboard.post_stats.average_read_time_desc'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),
        ];
    }
}
