<?php

namespace App\Filament\Resources\PostCategories\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label("Nom")
                    ->searchable(),
                TextColumn::make('slug')
                    ->label("Slug")
                    ->searchable(),
                TextColumn::make("posts_count")
                    ->badge()
                    ->label("Nombre d'articles")
                    ->default(0),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->translateLabel()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make()->disabled(fn($record) => $record->posts_count !== 0)
                ])
            ])->recordActionsColumnLabel("Actions")
            ->toolbarActions([
                BulkActionGroup::make([

                ]),
            ]);
    }
}
