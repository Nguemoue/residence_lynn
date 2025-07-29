<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum StockTypeEnum: string implements HasLabel
{
    case LIMITED = 'limited';
    case UNLIMITED = 'unlimited';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this){
            self::LIMITED => "Quantite defini",
            self::UNLIMITED => "Illimite"
        };
    }
}
