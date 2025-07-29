<?php

declare(strict_types=1);

namespace App\Domain\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum BookingStatusEnum: string implements HasLabel , HasColor {
    case APPROVED = 'paid';
    case  PENDING = 'pending';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';



    public function label(): string
    {
        return $this->name;
    }
    public function badgeColor(): string
    {
        return match ($this){
            default=>'badge-primary'
        };

    }

    public function getLabel(): string|Htmlable|null
    {
        return __('status.'.$this->value);
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::CANCELLED => 'gray',
            self::REJECTED => 'warning',
            self::APPROVED => 'success',
        };
    }
}
