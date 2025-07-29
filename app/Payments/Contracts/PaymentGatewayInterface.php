<?php

declare(strict_types=1);

namespace App\Payments\Contracts;

use App\Payments\Providers\AbstractGateway;
use App\Payments\DTO\{PaymentRequestDTO, PaymentResponseDTO, RefundRequestDTO, RefundResponseDTO};

/**
 * @mixin AbstractGateway
 */
interface PaymentGatewayInterface
{
    public function createPayment(PaymentRequestDTO $dto): PaymentResponseDTO;

    /** Annule un paiement en attente ou autorisé. */
    public function cancel(string $reference): bool;

    /** Rembourse tout ou partie d’une transaction. */
    public function refund(RefundRequestDTO $dto): RefundResponseDTO;

    /**
     * Un provider peut nativement gérer les webhooks ; si oui, implémentez `SupportsWebhooks`.
     * Cette méthode n’apparaît pas ici pour éviter de l’imposer aux gateways sans webhook.
     */

    public function hasSuccessPayment(string  $reference);

    public function handleSuccessCheckout(string $reference):void;
}
