<?php

namespace App\Filament\Widgets;

use App\Models\Tag;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Number;

class TagStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected  ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 'full';


    protected function getStats(): array
    {
        $startDate = $this->filters['start_date'] ?? null;
        $endDate = $this->filters['end_date'] ?? null;

        $baseQuery = Tag::query()
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate));

        $totalTags = $baseQuery->count();
        $mostUsedTag = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->first();

        return [
            Stat::make(__('dashboard.tag_stats.total_tags'), Number::format($totalTags))
                ->description(__('dashboard.tag_stats.total_tags_desc'))
                ->descriptionIcon('heroicon-m-tag')
                ->color('primary'),
            Stat::make(__('dashboard.tag_stats.most_used_tag'), $mostUsedTag?->name ?? __('dashboard.tag_stats.none'))
                ->description(__('dashboard.tag_stats.most_used_tag_desc', ['count' => $mostUsedTag?->posts_count ?? 0]))
                ->descriptionIcon('heroicon-m-star')
                ->color('success'),
        ];
    }
}
