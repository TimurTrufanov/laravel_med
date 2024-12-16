<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorsWorkloadRequest extends FormRequest
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
            'clinic_id' => 'nullable|exists:clinics,id',
            'specialization_id' => 'nullable|exists:specializations,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'clinic_id.exists' => 'Обрана клініка не існує.',
            'specialization_id.exists' => 'Обрана спеціалізація не існує.',
            'doctor_id.exists' => 'Обраний лікар не існує.',
            'start_date.date_format' => 'Дата початку повинна бути у форматі YYYY-MM-DD.',
            'end_date.date_format' => 'Дата завершення повинна бути у форматі YYYY-MM-DD.',
            'end_date.after_or_equal' => 'Дата завершення не може бути раніше дати початку.',
        ];
    }
}
