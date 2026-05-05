<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PackageRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Asumsikan otorisasi via Middleware auth di rute
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:haji,umroh',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
            'price' => 'required|numeric|min:0',
            'total_seats' => 'required|integer|min:1',
            'hotel_mekkah' => 'nullable|string|max:255',
            'hotel_madinah' => 'nullable|string|max:255',
            'airline' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['is_active' => $this->has('is_active')]);
    }
}