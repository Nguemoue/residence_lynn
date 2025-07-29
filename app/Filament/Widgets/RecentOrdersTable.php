<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentOrdersTable extends TableWidget
{
    protected  ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->with(['items.product'])
                    ->latest()
                    ->take(5)
            )
            ->columns([
                TextColumn::make('uuid')
                    ->label(__('dashboard.recent_orders.uuid'))
                    ->sortable(),
                TextColumn::make('full_name')
                    ->label(__('dashboard.recent_orders.customer'))
                    ->sortable(),
                TextColumn::make('total')
                    ->label(__('dashboard.recent_orders.total'))
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('dashboard.recent_orders.status'))
                    ->formatStateUsing(fn($state) => ucfirst(__($state->value)))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('dashboard.recent_orders.created_at'))
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
