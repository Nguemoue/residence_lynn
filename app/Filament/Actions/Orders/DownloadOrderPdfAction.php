<?php

namespace App\Filament\Actions\Orders;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class DownloadOrderPdfAction
{

    public static function make()
    {
        return Action::make('download_order_pdf')
            ->label('download_pdf')
            ->translateLabel()
            ->url(function (Order $record){
                return route('orders.pdf',['order' => $record]);
            },true)
            ->icon(Heroicon::CloudArrowDown);
    }
}
