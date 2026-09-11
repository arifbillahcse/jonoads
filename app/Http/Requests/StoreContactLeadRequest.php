<?php

namespace App\Http\Requests;

use App\Support\SpamGuard;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreContactLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'monthly_spend' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please tell us your name.',
            'email.required' => 'We need an email address to reply to.',
            'email.email' => 'That email address does not look right.',
            'message.required' => 'Tell us a little about what you need.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            // Deliberately vague: a bot learns nothing about which check it failed,
            // and a person who somehow trips it still gets a way forward.
            if (! SpamGuard::honeypotIsClean($this->input(SpamGuard::HONEYPOT))
                || ! SpamGuard::elapsedIsPlausible($this->input(SpamGuard::TIMESTAMP))) {
                $validator->errors()->add(
                    'message',
                    'We could not process that submission. Please try again, or email us directly.',
                );
            }
        });
    }
}
