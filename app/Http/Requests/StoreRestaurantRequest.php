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
            'latitude' => 'nullable|numeric|between:-90,90|required_with:longitude',
            'longitude' => 'nullable|numeric|between:-180,180|required_with:latitude',
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
            'latitude.required_with' => 'Jeśli podajesz szerokość geograficzną, musisz też podać długość.',
            'longitude.required_with' => 'Jeśli podajesz długość geograficzną, musisz też podać szerokość.',
            'latitude.numeric' => 'Szerokość musi być liczbą.',
            'longitude.numeric' => 'Długość musi być liczbą.',
            'latitude.between' => 'Szerokość musi być pomiędzy -90 a 90.',
            'longitude.between' => 'Długość musi być pomiędzy -180 a 180.',
        ];
    }
}
