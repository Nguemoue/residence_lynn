<?php

namespace App\Filament\Dashboard\Resources\Testimonials\Schemas;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('author')
                    ->default(Filament::auth()->user()?->name)
                    ->required(),
                TextInput::make('location')->default(Filament::auth()->user()?->address??''),
            ]);
    }
}
