<?php

namespace App\Filament\Resources\Faqs\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FaqsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')->limit(60)->searchable(),
                TextColumn::make('answer')->limit(60)->html(),
                IconColumn::make('is_active')->boolean()->label("Actif ?"),
                TextColumn::make('updated_at')
                    ->translateLabel()
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make()
                ])
            ])
            ->defaultDateTimeDisplayFormat("j M Y H:i")
            ->reorderable('position')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
