<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\CheckoutDataDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Booking;

final class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust based on your authorization logic (e.g., auth()->check())
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'name' => ['required', 'string', 'max:100'],
            //'address_line1' => ['required', 'string', 'max:255'],
            //'city' => ['required', 'string', 'max:100'],
            //'postal_code' => ['required', 'string', 'max:20'],
            //'country' => ['required', 'string', 'max:2'], // ISO 3166-1 alpha-2 country code
            'accommodation_id' => [
                'required',
                'exists:accommodations,id',
                // Custom rule to check availability
                function ($attribute, $value, $fail) {
                    $startDate = $this->input('start_date');
                    $endDate = $this->input('end_date');

                    if ($startDate && $endDate) {
                        $conflictingBookings = Booking::where('accommodation_id', $value)
                            ->where(function ($query) use ($startDate, $endDate) {
                                $query->whereBetween('start_date', [$startDate, $endDate])
                                    ->orWhereBetween('end_date', [$startDate, $endDate])
                                    ->orWhere(function ($query) use ($startDate, $endDate) {
                                        $query->where('start_date', '<=', $startDate)
                                            ->where('end_date', '>=', $endDate);
                                    });
                            })
                            ->exists();

                        if ($conflictingBookings) {
                            $fail('L\'hébergement n\'est pas disponible pour les dates sélectionnées.');
                        }
                    }
                },
            ],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'guest_number' => ['required', 'integer', 'min:1'],
        ];
    }

    public function toDto(): CheckoutDataDto
    {
        return new CheckoutDataDto(
            email: $this->string('email')->toString(),
            phone: $this->string('phone')->toString(),
            fullName: $this->string('name')->toString(),
            addressLine1: $this->string('address_line1')->toString(),
            city: $this->string('city')->toString(),
            postalCode: $this->string('postal_code')->toString(),
            country: $this->string('country')->toString(),
        );
    }
}
