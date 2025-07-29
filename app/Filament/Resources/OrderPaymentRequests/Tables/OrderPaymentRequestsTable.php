<?php

namespace App\Filament\Resources\OrderPaymentRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderPaymentRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.code')
                    ->label('Code de commande')
                    ->badge()
                    ->placeholder("Commande non finalise")
                    ->searchable(),
                TextColumn::make('payer_name')
                    ->label('Name')
                    ->searchable()
                ,
                TextColumn::make('payer_surname')
                    ->label('Surname')
                    ->searchable()
                ,
                TextColumn::make('payer_email')
                    ->label('Email')
                    ->searchable(),
                /*TextColumn::make('payment_metadata.amount_total')
                    ->label('Total Amount')
                    ->placeholder("-")
                    ->formatStateUsing(fn ($record) => $record->payment_metadata['amount_total']??0 / 100), // Convert cents to euros*/
                /*TextColumn::make('payment_metadata.status')
                    ->label('Payment Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'warning',
                        'complete' => 'success',
                        'expired' => 'danger',
                        default => 'gray',
                    })
                    ,*/
                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'stripe' => 'Stripe',
                        'paypal' => 'Paypal'
                        // Add other payment methods if applicable
                    ]),
                SelectFilter::make('payment_metadata.status')
                    ->label('Payment Status')
                    ->options([
                        'open' => 'Open',
                        'complete' => 'Complete',
                        'expired' => 'Expired',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([

                ]),
            ])
            ->modifyQueryUsing(fn($query) => $query->whereDoesntHave('order'))
            ->defaultCurrency(defaultCurrency())
            ->defaultNumberLocale("fr_FR")
            ->defaultSort('created_at', 'desc');
    }
}
