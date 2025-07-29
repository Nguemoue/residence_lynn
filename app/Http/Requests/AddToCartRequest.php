<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'product_id' => ['required','integer','exists:products,id'],
            'quantity'   => ['required','integer','min:1'],
        ];
    }

    public function toDto(): \App\DTO\CartItemDto
    {
        return new \App\DTO\CartItemDto(
            productId: (int) $this->input('product_id'),
            quantity : (int) $this->input('quantity'),
        );
    }
}
