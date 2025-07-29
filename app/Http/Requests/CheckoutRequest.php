<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\CheckoutDataDto;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'email'          => ['required','email:rfc,dns'],
            'phone'          => ['required','string','max:30'],
            'surname'      => ['required','string','max:100'],
            'address'  => ['required','string','max:150'],
            'city'           => ['required','string','max:80'],
            'postal_code'    => ['required','string','max:20'],
            'country'        => ['sometimes','string','size:2'],
        ];
    }

    public function toDto(): CheckoutDataDto
    {
        return new CheckoutDataDto(
            email        : $this->string('email')->toString(),
            phone        : $this->string('phone')->toString(),
            fullName     : $this->string('full_name')->toString(),
            addressLine1 : $this->string('address_line1')->toString(),
            city         : $this->string('city')->toString(),
            postalCode   : $this->string('postal_code')->toString(),
            country      : $this->string('country', default:'FR')->toString(),
        );
    }
}
