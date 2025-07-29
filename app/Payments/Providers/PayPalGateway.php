<?php

declare(strict_types=1);

namespace App\Payments\Providers;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Payments\Contracts\SupportsWebhooks;
use App\Payments\DTO\{
    PaymentRequestDTO,
    PaymentResponseDTO,
    RefundRequestDTO,
    RefundResponseDTO,
    WebhookDTO
};
use App\Payments\Enums\PaymentStatus;

/**
 * Provider PayPal basé sur le package "srmklive/paypal".
 * Flow : ORDER → APPROVE → (facultatif) CAPTURE → REFUND.
 *
 * Installation :
 *   composer require srmklive/paypal
 *   php artisan vendor:publish --provider="Srmklive\PayPal\Providers\PayPalServiceProvider"
 */
class PayPalGateway extends AbstractGateway implements SupportsWebhooks
{
    public function __construct(private PayPalClient $paypal)
    {
        // Charge les credentials (client_id / secret) du fichier config/paypal.php
        $this->paypal->setApiCredentials($this->config('api_keys'));

        // Récupère et stocke un access‑token
        $this->paypal->getAccessToken();
        // Définit la devise par défaut pour les appels qui ne précisent pas currency_code
        //$this->paypal->setCurrency($this->config('config.fallback_currency'));
    }

    public function getName(): string
    {
        return 'paypal';
    }

    /* ------------------------------------------------------- */
    /*   Création d’une commande & redirection (Checkout)      */
    /* ------------------------------------------------------- */
    public function createPayment(PaymentRequestDTO $dto): PaymentResponseDTO
    {
        //validate the currency
        $this->validateCurrency(currency: $dto->currency->value);

        $this->paypal->setCurrency($dto->currency->value);
        $order = $this->paypal->createOrder([
            'intent'              => 'CAPTURE',
            'application_context' => [
                'return_url' => $dto->returnUrl,
                'cancel_url' => $dto->cancelUrl,
                'brand_name' => config('app.name'),
                'user_action' => 'PAY_NOW',
            ],
            'purchase_units'      => [[
                'reference_id' => $dto->reference,
                'description'  => $dto->description,
                'amount' => [
                    'currency_code' => $dto->currency->value,
                    'value'    => $this->fromCents($dto->amountCents)
                ],
            ]],
        ]);


        $approveUrl = collect($order['links'] ?? [])
            ->firstWhere('rel', 'approve')['href'] ?? null;

        return new PaymentResponseDTO(
            gateway:    'paypal',
            reference:  $order['id'],   // Order ID
            status:     PaymentStatus::PENDING,
            redirectUrl:$approveUrl,
            raw:        $order,
        );
    }

    /* ------------------------------------------------------- */
    /*   Annulation (pas d’API pour VOID avant capture)        */
    /* ------------------------------------------------------- */
    public function cancel(string $reference): bool
    {
        return true; // On considère l’annulation client comme réussie
    }

    /* ------------------------------------------------------- */
    /*   Remboursement total / partiel                         */
    /* ------------------------------------------------------- */
    public function refund(RefundRequestDTO $dto): RefundResponseDTO
    {
        // Signature : refundCapturedPayment(string $capture_id, string $invoice_id, float $amount, string $note)

        $invoiceId = $dto->metadata['invoice_id'] ?? '';
        $note      = $dto->metadata['note']       ?? '';

        // Null → remboursement total (on passe 0.0 car le paramètre est requis)
        $amountFloat = $dto->amountCents !== null
            ? $this->fromCents($dto->amountCents)
            : 0.0;

        $refund = $this->paypal->refundCapturedPayment(
            $dto->reference,   // capture_id
            $invoiceId,        // invoice_id
            $amountFloat,      // montant
            $note              // note
        );

        return new RefundResponseDTO(
            gateway:   'paypal',
            reference: $refund['id'] ?? $dto->reference,
            status:    PaymentStatus::REFUNDED,
            raw:       $refund,
        );
    }

    /* ------------------------------------------------------- */
    /*   Mapping Webhooks → statut interne                     */
    /* ------------------------------------------------------- */
    public function handleWebhook(string $signatureHeader, array $payload): WebhookDTO
    {
        // Le package vérifie déjà la signature si l’IPN est configuré.
        $event    = $payload['event_type'] ?? '';
        $resource = $payload['resource']    ?? [];

        $status = match ($event) {
            'CHECKOUT.ORDER.APPROVED'   => PaymentStatus::AUTHORIZED,
            'PAYMENT.CAPTURE.COMPLETED' => PaymentStatus::COMPLETED,
            'PAYMENT.CAPTURE.DENIED'    => PaymentStatus::FAILED,
            'PAYMENT.CAPTURE.REFUNDED'  => PaymentStatus::REFUNDED,
            default                     => PaymentStatus::PENDING,
        };

        return new WebhookDTO(
            gateway:   'paypal',
            reference: $resource['id'] ?? 'unknown',
            status:    $status,
            raw:       $payload,
        );
    }


    public function hasSuccessPayment(string $reference):bool
    {
        $response = $this->paypal->capturePaymentOrder($reference);
        return isset($response['status']) && ($response['status'] === 'COMPLETED');
    }

}
