<?php

declare(strict_types=1);

namespace App\Payments\Traits;

trait ConvertsAmounts
{
    protected function toCents(float|int $amount, int $precision = 2): int
    {
        return (int) round($amount * (10 ** $precision));
    }

    protected function fromCents(int $cents, int $precision = 2): float
    {
        return $cents / (10 ** $precision);
    }
}
