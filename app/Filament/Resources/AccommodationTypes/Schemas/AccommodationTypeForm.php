<?php

namespace App\Filament\Resources\AccommodationTypes\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AccommodationTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('price_per_night')->numeric()->required()->prefix(defaultCurrency()),
                ])->columnSpanFull(),

                CheckboxList::make('services')->relationship('services', 'name')->columns(4)->columnSpanFull(),
                RichEditor::make('description')->required()->columnSpanFull(),
                TagsInput::make('amenities')->columnSpanFull(),
                Section::make('Gallery')
                    ->description("Upload the cover image and gallery images for this accommodation type.")
                    ->schema([
                        FileUpload::make('cover_image')->imageEditor()
                            ->imageCropAspectRatio("1:1")
                            ->image()
                            ->disk('public')->required()->columnSpanFull(),
                        FileUpload::make('gallery')->image()->disk('public')->multiple()->required()->columnSpanFull()->columns(2),
                    ])->columnSpanFull()

            ]);
    }
}
