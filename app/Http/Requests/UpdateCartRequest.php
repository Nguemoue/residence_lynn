<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\CartItemDto;

class UpdateCartRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'quantity' => ['required','integer','min:1'],
        ];
    }

    public function toDto(int $productId): CartItemDto
    {
        return new CartItemDto(
            productId: $productId,
            quantity : (int) $this->input('quantity'),
        );
    }
}
