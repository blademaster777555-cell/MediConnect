<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Any authenticated user can book
    }

    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctor_profiles,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string',
            'patient_note' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'date.after_or_equal' => 'Ngày đặt hẹn không thể ở quá khứ.',
            'doctor_id.exists' => 'Bác sĩ không tồn tại.',
        ];
    }
}
