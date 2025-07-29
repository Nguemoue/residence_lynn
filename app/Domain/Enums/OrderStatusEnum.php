<?php

declare(strict_types=1);

namespace App\Domain\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum OrderStatusEnum: string implements HasLabel , HasColor {
    case RECEIVED = 'received';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';

    public function step(): int
    {
        return match ($this) {
            self::RECEIVED => 1,
            self::PROCESSING => 2,
            self::SHIPPED => 3,
            self::DELIVERED => 4,
        };
    }
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
            self::RECEIVED => 'gray',
            self::DELIVERED => 'gray',
            self::PROCESSING => 'warning',
            self::SHIPPED => 'success',
        };
    }
}
