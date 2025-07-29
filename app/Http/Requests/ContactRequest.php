<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\ContactMessageDto;

class ContactRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'    => ['required','string','max:100'],
            'email'   => ['required','email'],
            'subject' => ['required','string','max:150'],
            'message' => ['required','string','max:5000'],
        ];
    }

    public function toDto(): ContactMessageDto
    {
        return new ContactMessageDto(
            name    : $this->string('name')->toString(),
            email   : $this->string('email')->toString(),
            subject : $this->string('subject')->toString(),
            message : $this->string('message')->toString(),
        );
    }
}
