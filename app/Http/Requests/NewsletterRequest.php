<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\DTO\NewsletterSubscriptionDto;

class NewsletterRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'email' => ['required','email', Rule::unique('subscribers','email')],
        ];
    }

    public function toDto(): NewsletterSubscriptionDto
    {
        return new NewsletterSubscriptionDto(
            email: $this->string('email')->toString()
        );
    }
}
