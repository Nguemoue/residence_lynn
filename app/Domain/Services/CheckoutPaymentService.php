<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Enums\OrderStatusEnum;
use App\DTO\CheckoutDataDto;
use App\Exceptions\{CartEmptyException};
use App\Models\Order;
use Illuminate\Support\Facades\DB;

final class CheckoutPaymentService
{
    public function __construct()
    {}
    public function validatePaymentRequest(array $metadata)
    {

    }
}
