<?php

namespace App\Filament\Resources\OrderPaymentRequests\Pages;

use App\Filament\Resources\OrderPaymentRequests\OrderPaymentRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrderPaymentRequest extends ViewRecord
{
    protected static string $resource = OrderPaymentRequestResource::class;
    protected static ?string $title = "Suivi de commande";
    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
