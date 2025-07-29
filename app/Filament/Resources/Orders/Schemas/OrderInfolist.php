<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Order;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('order.base_info'))->schema([
                    TextEntry::make('uuid')->badge()->columnSpanFull()->label('Reference'),
                    TextEntry::make('code')->badge()->columnSpanFull()->translateLabel(),
                    TextEntry::make('subtotal')->money(defaultCurrency())->translateLabel(),
                    TextEntry::make('discount')->money(defaultCurrency())->translateLabel(),
                    TextEntry::make('total')->numeric()->money(defaultCurrency())->translateLabel(),
                    TextEntry::make('created_at')->dateTime(defaultDisplayFormatDate())->translateLabel(),
                ])
                    ->collapsible()
                    ->columns(2),

                Section::make(__('order.user_info'))->schema([
                    TextEntry::make('email')->translateLabel(),
                    TextEntry::make('phone')->translateLabel(),
                    TextEntry::make('full_name')->translateLabel(),
                    TextEntry::make('address_line1')->label("Adresse de livraison"),
                    TextEntry::make('address_line2'),
                    TextEntry::make('city')->translateLabel(),
                    TextEntry::make('postal_code')->translateLabel(),
                    TextEntry::make('country')->translateLabel(),
                ])->columns()->collapsible(),
                Section::make(__('order.payment_info'))->schema([

                    KeyValueEntry::make('status_note')->state(fn(Order $record)=>collect($record->status_note)->mapWithKeys(fn($value,$key)=>[__('status.'.$key)=>$value]))
                        ->keyLabel("Status")->valueLabel("Description")->label("Notes de la comande"),
                    TextEntry::make('status')->badge()->label("Status actuel de la commande"),
                    TextEntry::make('orderPaymentRequest.payment_reference')->label("Reference de paiement")->badge(),
                ])->columnSpanFull()->collapsible(),

            ]);
    }
}
