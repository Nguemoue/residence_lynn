<?php

namespace App\Filament\Resources\OrderPaymentRequests;

use App\Domain\Enums\FilamentNavigationGroupEnum;
use App\Filament\Resources\OrderPaymentRequests\Pages\ListOrderPaymentRequests;
use App\Filament\Resources\OrderPaymentRequests\Pages\ViewOrderPaymentRequest;
use App\Filament\Resources\OrderPaymentRequests\Schemas\OrderPaymentRequestInfolist;
use App\Filament\Resources\OrderPaymentRequests\Tables\OrderPaymentRequestsTable;
use App\Models\OrderPaymentRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class OrderPaymentRequestResource extends Resource
{
    protected static ?string $model = OrderPaymentRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = FilamentNavigationGroupEnum::BOOKING;


    public static function getNavigationLabel(): string
    {
        return __('menu.order_payment_requests');
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrderPaymentRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrderPaymentRequestsTable::configure($table);
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
            'index' => ListOrderPaymentRequests::route('/'),
            'view' => ViewOrderPaymentRequest::route('/{record}'),
        ];
    }
}
