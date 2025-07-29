<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    /**
     * @return string|null
     */
    public  function getTitle(): \Illuminate\Contracts\Support\Htmlable|string
    {
        /** @var Product $product */
        $product = $this->record;
        return $product->name;
    }
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->disabled(fn($record)=>$record->orderItems()->count() > 0),
        ];
    }
}
