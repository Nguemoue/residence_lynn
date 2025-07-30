<?php

namespace App\Models;

use App\Domain\Enums\BookingStatusEnum;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function accommodation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #[Scope]
    protected function approved(Builder $query): Builder
    {
        return $query->where('status', BookingStatusEnum::APPROVED->value);
    }

    #[Scope]
    protected function pending(Builder $query): Builder
    {
        return $query->where('status', BookingStatusEnum::PENDING->value);
    }

    #[Scope]
    protected function canceled(Builder $query): Builder
    {
        return $query->where('status', BookingStatusEnum::CANCELLED->value);
    }

}
