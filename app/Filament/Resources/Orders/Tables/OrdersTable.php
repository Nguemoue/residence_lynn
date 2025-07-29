<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Domain\Enums\OrderStatusEnum;
use App\Filament\Actions\Orders\DownloadOrderPdfAction;
use App\Filament\Actions\Orders\UpdateOrderStatusAction;
use App\Payments\Enums\Currency;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Arr;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->badge(),
                TextColumn::make('full_name')->translateLabel()->searchable(),
                TextColumn::make('email')->translateLabel()->searchable(),
                TextColumn::make('address_line1')
                    ->translateLabel()
                    ->searchable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('discount')->numeric()->money()->translateLabel(),
                TextColumn::make('total')->numeric()->money()->translateLabel(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label("Date")
                    ->translateLabel(),
            ])
            ->filters([
                SelectFilter::make('status')->options(OrderStatusEnum::class)
            ])
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filtre'),
            )
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    UpdateOrderStatusAction::make(),
                    DownloadOrderPdfAction::make()
                ])

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultDateTimeDisplayFormat(defaultDisplayFormatDate())
            ->defaultNumberLocale('fr_FR')
            ->defaultCurrency(Currency::EUR->value);
    }
}
