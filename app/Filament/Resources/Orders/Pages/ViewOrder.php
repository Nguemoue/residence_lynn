<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Actions\Orders\DownloadOrderPdfAction;
use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function getTitle(): string|Htmlable
    {
        /** @var Order $record */
        $record = $this->record;

        return "Commande #".$record->code;
    }

    protected function getHeaderActions(): array
    {
        return [
            DownloadOrderPdfAction::make()
        ];
    }
}
