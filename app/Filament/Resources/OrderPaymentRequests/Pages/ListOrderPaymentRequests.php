<?php

namespace App\Filament\Resources\OrderPaymentRequests\Pages;

use App\Filament\Resources\OrderPaymentRequests\OrderPaymentRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListOrderPaymentRequests extends ListRecords
{
    protected static string $resource = OrderPaymentRequestResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('menu.order_payment_requests');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

}
