<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:restaurants,name',
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048',
            'cuisines' => 'array',
            'cuisines.*' => 'exists:cuisines,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nazwa restauracji jest wymagana.',
            'address.required' => 'Adres jest wymagany.',
            'image.image' => 'Plik musi być obrazem.',
            'image.max' => 'Plik nie może przekraczać 2MB.',
            'name.unique' => 'Restauracja o takiej nazwie już istnieje.',
        ];
    }
}
