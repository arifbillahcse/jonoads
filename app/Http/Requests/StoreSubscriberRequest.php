<?php

namespace App\Http\Requests;

use App\Support\SpamGuard;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreSubscriberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Not unique: re-subscribing an existing address is handled in the
            // controller so an already-subscribed person sees a normal message
            // rather than a validation error.
            'email' => ['required', 'email:rfc', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Enter an email address to subscribe.',
            'email.email' => 'That email address does not look right.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (! SpamGuard::honeypotIsClean($this->input(SpamGuard::HONEYPOT))
                || ! SpamGuard::elapsedIsPlausible($this->input(SpamGuard::TIMESTAMP))) {
                $validator->errors()->add('email', 'We could not process that. Please try again.');
            }
        });
    }
}
