<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Imię jest wymagane.',
            'name.string'   => 'Imię musi być tekstem.',
            'name.max'      => 'Imię może mieć maksymalnie 255 znaków.',

            'email.required' => 'Adres e-mail jest wymagany.',
            'email.string'   => 'Adres e-mail musi być tekstem.',
            'email.email'    => 'Podaj poprawny adres e-mail.',
            'email.max'      => 'Adres e-mail może mieć maksymalnie 255 znaków.',
            'email.unique'   => 'Ten adres e-mail jest już zajęty.',
        ];
    }

}
