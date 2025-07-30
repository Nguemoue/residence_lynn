<?php

namespace App\Filament\Resources\Accommodations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AccommodationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->translateLabel(),
                TextColumn::make('accommodationType.name')->sortable()->translateLabel(),
                TextColumn::make('price')->money()->translateLabel(),
                ImageColumn::make('cover_image')->disk('public')->translateLabel(),
                IconColumn::make('is_available')->boolean()->translateLabel(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->defaultCurrency(defaultCurrency())
            ->defaultDateDisplayFormat(defaultDisplayFormatDate());
    }
}
