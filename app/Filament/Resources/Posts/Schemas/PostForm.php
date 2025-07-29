<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->afterStateUpdatedJs(<<<'JS'
$set('slug',$state?.replaceAll(' ','-').toLowerCase()??''
JS)->label("Titre")
                    ->required(),
                TextInput::make('slug')
                    ->label("Slug")
                    ->required(),
                Select::make('post_category_id')
                    ->relationship('category','name')
                    ->required()
                    ->label("Categorie"),
                Select::make('author_id')
                    ->relationship('author', 'name')
                    ->label("Auteur"),
                CheckboxList::make('tags')->relationship(titleAttribute: 'name')->columns(3)->columnSpanFull(),
                Textarea::make('excerpt')
                    ->label("Petite description")
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->required()
                    ->label("Contenu")
                    ->columnSpanFull(),
                FileUpload::make('cover_image')
                    ->image()
                    ->imageEditor()
                    ->directory("posts")
                    ->disk('public')
                    ->imageCropAspectRatio("16:9")
                    ->columnSpanFull()->label("Photo de couverture"),
                Toggle::make('is_published')
                    ->label("Publier le l'article ? ")
                    ->required(),
            ]);
    }
}
