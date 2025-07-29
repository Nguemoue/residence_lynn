<?php

namespace App\Filament\Resources\OrderPaymentRequests\Schemas;


use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderPaymentRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Information sur le client ')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('payer_name')
                            ->label('Nom'),
                        TextEntry::make('payer_surname')
                            ->label('Prenom'),
                        TextEntry::make('payer_email')
                            ->label('Email'),
                        TextEntry::make('payer_phone')
                            ->label('Numero de telephone'),
                        TextEntry::make('payer_address')
                            ->label('Address de livraison'),
                        TextEntry::make('payer_city')
                            ->label('Ville'),
                        TextEntry::make('payer_postal_code')
                            ->label('Code Postal'),
                    ]),
                Section::make('Detail de paiement')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('payment_reference')
                            ->label('Payment Reference')->translateLabel(),
                        TextEntry::make('payment_method')
                            ->label('Payment Method')->translateLabel(),
                        TextEntry::make('created_at')
                            ->label('Created At')->translateLabel()
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label('Updated At')->translateLabel()
                            ->dateTime(),
                        TextEntry::make('payment_metadata.amount_total')
                            ->label('Total Amount')->translateLabel()
                            ->money(defaultCurrency(), true), // Format as currency (EUR)
                        TextEntry::make('payment_metadata.status')
                            ->label('Payment Status')->translateLabel(),
                        TextEntry::make('payment_metadata.url')
                            ->label('Payment URL')->translateLabel()
                            ->formatStateUsing(fn($state)=>str($state)->limit(50))
                            ->url(fn($record)=>$record->payment_metadata['url'])
                            ->columnSpanFull()
                            ->openUrlInNewTab(),
                    ]),
                Section::make('Details du panier ')
                    ->schema([
                        RepeatableEntry::make('metadata.cart')
                            ->label('Cart Items')
                            ->translateLabel()
                            ->schema([
                                TextEntry::make('product.name')
                                    ->label('Product Name')->translateLabel(),
                                TextEntry::make('product.price')
                                    ->label('Unit Price')->translateLabel()
                                    ->money('eur', true),
                                TextEntry::make('quantity')
                                    ->label('Quantity')->translateLabel(),
                                TextEntry::make('subtotal')
                                    ->label('Subtotal')->translateLabel()
                                    ->money('eur', true),
                                TextEntry::make('product.description')
                                    ->label('Description')->translateLabel()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ])->columnSpanFull(),
            ]);
    }
}
