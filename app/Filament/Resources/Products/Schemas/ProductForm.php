<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Enums\StockTypeEnum;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->components([
                TextInput::make('name')
                    ->afterStateUpdatedJs(<<<'JS'
                        $set('slug', $state?.replaceAll(' ', '-').toLowerCase() ?? '')
                    JS)
                    ->required(),

                TextInput::make('slug')
                    ->unique()
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix(defaultCurrency()),
                Textarea::make('short_description')
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
                CheckboxList::make('tags')->relationship(titleAttribute: 'name')->columns(3)->columnSpanFull(),
                Section::make('Stock Management')->collapsible()->schema([
                    Select::make('stock_type')
                        ->enum(StockTypeEnum::class)
                        ->required(),
                    TextInput::make('quantity')
                        ->numeric()
                        ->minValue(0)
                        ->requiredIf('stock_type', 'limited')
                        ->nullable()
                        ->hiddenJs(<<<'JS'
                     $get('stock_type') === 'unlimited'
JS),
                ])->columnSpanFull()->columns(2),

                Section::make('Promotion')->collapsible()->schema([
                    Toggle::make('is_featured')->required(),
                    TextInput::make('discount_price')->numeric()
                    ->visibleJs(<<<'JS'
                    $get('is_featured') === true
JS)->prefix(defaultCurrency()),
                ])->columnSpanFull()->columns(2)->extraAttributes([
                    'style' => 'justify-content:end'
                ]),
                Section::make('Images')->collapsible()->collapsed()->schema([
                    FileUpload::make('cover_image')
                        ->image()
                        ->disk('public')
                        ->imageCropAspectRatio('1:1')
                        ->imageEditor(),
                    FileUpload::make('gallery')
                        ->image()
                        ->multiple()
                        ->disk('public')
                        ->columnSpanFull(),
                ])->columnSpanFull(),
            ]);
    }
}
