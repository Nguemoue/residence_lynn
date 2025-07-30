<?php

namespace App\Filament\Resources\Accommodations\Schemas;

use App\Models\AccommodationType;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AccommodationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')->required(),
                Select::make('accommodation_type_id')->relationship('accommodationType', 'name')->required(),
                RichEditor::make('description')->columnSpanFull()->required(),

                Section::make("Supplements")->collapsible()->schema([
                    TagsInput::make('amenities')->columnSpanFull(),
                    CheckboxList::make('services')->relationship(titleAttribute: 'name')->columns(3)->columnSpanFull(),
                ])->columnSpanFull(),

                Section::make("Images")->collapsible()->schema([
                    FileUpload::make('cover_image')->image()->disk('public')->directory('accommodations')->required(),
                    FileUpload::make('gallery')->image()->multiple()->columnSpanFull(),
                ])->columnSpanFull(),


            ]);
    }
}
