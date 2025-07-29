<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

if (!function_exists('format_price')) {
    function format_price(float $amount): string
    {
        return number_format($amount, 2, ',', ' ') . ' €';
    }
}

if (!function_exists('generate_slug')) {
    function generate_slug(string $name): string
    {
        return Str::slug($name);
    }
}

if (!function_exists('is_active_badge')) {
    function is_active_badge(bool $state): string
    {
        return $state
            ? '<span class="badge badge-success">Actif</span>'
            : '<span class="badge badge-error">Inactif</span>';
    }
}

if (!function_exists('cart_total')) {
    function cart_total(array $items): float
    {
        return array_reduce($items, fn($total, $item) => $total + ($item['price'] * $item['quantity']), 0);
    }
}

if (!function_exists('json_response_success')) {
    function json_response_success(mixed $data = [], string $message = 'Opération réussie.'): Illuminate\Http\JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data]);
    }
}

if (!function_exists('json_response_error')) {
    function json_response_error(string $message = 'Une erreur est survenue.', int $code = 400): Illuminate\Http\JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], $code);
    }
}

if (!function_exists('generate_order_reference')) {
    function generate_order_reference(): string
    {
        return  'ORD-' . strtoupper(Str::random(12));
    }
}


if (!function_exists("defaultCurrency")){
    function defaultCurrency()
    {
        return config('project.default_currency');
    }
}

if (!function_exists("defaultDisplayFormatDate")){
    function defaultDisplayFormatDate(): string
    {
        return "j M Y H:i";
    }
}


if (!function_exists('whatsappUrl')){
    function whatsappUrl()
    {
        return str("https://wa.me/")->append(app(\App\Settings\GeneralSetting::class)->whatsappUrl)->toString();
    }
}
