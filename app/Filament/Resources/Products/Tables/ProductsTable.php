<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //TextColumn::make('#')->rowIndex()->numeric(),
                TextColumn::make('name')->searchable()->label("Nom"),
                ImageColumn::make('cover_image')->disk('public')->label("Photo"),
                TextColumn::make('category.name')->label("Categorie"),
                TextColumn::make('price')->money()->label("Prix"),
                TextColumn::make('is_featured')->badge()->formatStateUsing(fn($record)=>$record->is_featured?"Oui":"Non")->label("En promotion?"),
                TextColumn::make('discount_price')->placeholder('-')->money()
                    ->label("Prix promo")->state(fn(Product $record)=>$record->is_featured?$record->discount_price:null),
                //IconColumn::make('is_active')->boolean(),
                TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true)->translateLabel(),
                TextColumn::make('updated_at')->dateTime()->toggleable(isToggledHiddenByDefault: true)->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->recordActions([

                ActionGroup::make([
                    DeleteAction::make()
                        ->tooltip(fn($record)=>$record->order_items_count > 0 ? "Impossible de supprimer":"Supprimer le produit")
                        ->disabled(fn(Product $record) => $record->order_items_count > 0),
                    EditAction::make(),
                    ViewAction::make(),
                ])->label("Action")

            ])
            ->toolbarActions([
                BulkActionGroup::make([

                ]),
            ])->defaultCurrency(defaultCurrency())
            ->modifyQueryUsing(fn($query)=>$query->withCount('orderItems'));
    }
}
