<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'specialization_id' => 'required|exists:specializations,id',
            'city_id' => 'required|exists:cities,id',
            'bio' => 'nullable|string|max:1000',
            'license_number' => 'nullable|string|max:50',
            'consultation_fee' => 'nullable|numeric|min:0',
            'certificate' => 'nullable|array',
            'certificate.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
