<?php

namespace App\Filament\Actions\Orders;

use App\Domain\Enums\OrderStatusEnum;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;

class UpdateOrderStatusAction
{
    public static function make()
    {
        return Action::make('update_order_status')->label("Mettre a niveau")
            ->icon(Heroicon::Pencil)
            ->schema([
                KeyValueEntry::make('status_note')->label("Notes deja enregistre ")->state(fn ($record) => collect($record->status_note)->mapWithKeys(fn($value,$key)=>[__('status.'.$key)=>$value])->toArray() )
                    ->keyLabel('Status')->valueLabel("Description"),
                Select::make('status')->required()->preload()
                    ->options(fn()=> collect(OrderStatusEnum::cases())->mapWithKeys(fn($item)=>[$item->value => __('status.'.$item->value)]))
                    ->default(fn(Order $record)=>$record->status->value)
                ->native(true)
                ->afterStateUpdated(fn(Order $record,Set $set,Get $get) => $set('description',$record->status_note[$get('status')]??null))
                ->reactive(),
                Textarea::make('description')
                    ->default(fn(Order $record,$state,$get)=> $record->status_note[$get('status')]??null)
                    ->label("Note")->required()->columnSpanFull()
            ])->action(function (Order $record,$data){
                $record->update([
                    'status'=>$data['status'],
                    'status_note'=> [...($record->status_note??[]),$data['status']=>$data['description']]
                ]);
                Notification::make()
                    ->success()
                    ->title("Enregistre")
                    ->body("Mis a jour")
                    ->send();
            });
    }
}
