<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Domain\Enums\OrderStatusEnum;
use App\Filament\Resources\PostCategories\Tables\PostCategoriesTable;
use App\Models\PostCategory;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->limit(50),
                TextColumn::make('category.name'),
                TextColumn::make('views')->numeric()->label(" Nbres vues")->badge(),
                ImageColumn::make('cover_image')->label("Poster")->disk('public'),
                TextColumn::make('author.name')->label("Auteur"),
                TextColumn::make('is_published')->badge()->formatStateUsing(fn($record)=>$record->is_published?"Oui":"Non")->label("Est publie?")->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('published_at')->dateTime("d/m/Y H:i")->label("Publie le"),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('post_category_id')->options(PostCategory::pluck('name','id'))->label("Cateogry"),
                Filter::make('is_published')
                    ->toggle()
            ])
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filtre'),
            )
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    ViewAction::make(),
                    DeleteAction::make()
                ])

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
