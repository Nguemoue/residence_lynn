<?php

namespace App\Filament\Resources\Orders;

use App\Domain\Enums\FilamentNavigationGroupEnum;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Pages\ViewOrder;
use App\Filament\Resources\Orders\RelationManagers\OrderItemsRelationManager;
use App\Filament\Resources\Orders\Schemas\OrderInfolist;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use App\Payments\Enums\Currency;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar;

    protected static string|UnitEnum|null $navigationGroup = FilamentNavigationGroupEnum::ORDER;


    public static function getNavigationLabel(): string
    {
        return __('menu.orders');
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrderInfolist::configure($schema)->defaultCurrency(Currency::EUR->value);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            OrderItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'view' => ViewOrder::route('/{record}'),
        ];
    }
}
