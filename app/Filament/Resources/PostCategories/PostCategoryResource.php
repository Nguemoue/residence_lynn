<?php

namespace App\Filament\Resources\PostCategories;

use App\Domain\Enums\FilamentNavigationGroupEnum;
use App\Filament\Resources\PostCategories\Pages\CreatePostCategory;
use App\Filament\Resources\PostCategories\Pages\EditPostCategory;
use App\Filament\Resources\PostCategories\Pages\ListPostCategories;
use App\Filament\Resources\PostCategories\Schemas\PostCategoryForm;
use App\Filament\Resources\PostCategories\Tables\PostCategoriesTable;
use App\Models\PostCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PostCategoryResource extends Resource
{
    protected static ?string $model = PostCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Folder;

    protected static string | UnitEnum | null $navigationGroup = FilamentNavigationGroupEnum::BLOG;
    public static function getNavigationLabel(): string
    {
        return __('menu.post_categories');
    }
    public static function form(Schema $schema): Schema
    {
        return PostCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostCategoriesTable::configure($table)->modifyQueryUsing(fn($query)=>$query->withCount('posts'));
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPostCategories::route('/'),
            //'create' => CreatePostCategory::route('/create'),
            //'edit' => EditPostCategory::route('/{record}/edit'),
        ];
    }
}
