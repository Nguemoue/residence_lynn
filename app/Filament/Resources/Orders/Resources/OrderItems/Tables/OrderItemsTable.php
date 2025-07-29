<?php

namespace App\Filament\Resources\Orders\Resources\OrderItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->translateLabel()
                    ->numeric(),
                TextColumn::make('quantity')
                    ->translateLabel()
                    ->prefix(" x ")
                    ->numeric(),
                TextColumn::make('unit_price')
                    ->translateLabel()
                    ->money(defaultCurrency()),
                TextColumn::make('total_price')
                    ->translateLabel()
                    ->money(defaultCurrency()),
            ])
            ->filters([
                //
            ])
            ->recordActions([

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
