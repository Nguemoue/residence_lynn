<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Number;

class ContactStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected  ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 3;

    protected function getStats(): array
    {
        $startDate = $this->filters['start_date'] ?? null;
        $endDate = $this->filters['end_date'] ?? null;

        $baseQuery = Contact::query()
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate));

        $totalContacts = $baseQuery->count();
        $recentContacts = Contact::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        return [
            Stat::make(__('dashboard.contact_stats.total_contacts'), Number::format($totalContacts))
                ->description(__('dashboard.contact_stats.total_contacts_desc'))
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make(__('dashboard.contact_stats.recent_contacts'), Number::format($recentContacts))
                ->description(__('dashboard.contact_stats.recent_contacts_desc'))
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success'),
        ];
    }
}
