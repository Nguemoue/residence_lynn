<?php

declare(strict_types=1);

namespace App\Domain\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum BookingStatusEnum: string implements HasLabel , HasColor {
    case APPROVED = 'approved';
    case  PENDING = 'pending';
    case CANCELLED = 'cancelled';



    public function label(): string
    {
        return __($this->name);
    }
    public function badgeColor(): string
    {
        return match ($this){
            self::PENDING => 'badge-warning',
            self::CANCELLED => 'badge-danger',
            self::APPROVED => 'badge-success',
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
            self::CANCELLED => 'warning',
            self::APPROVED => 'success',
        };
    }
}
