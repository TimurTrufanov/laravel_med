<?php

namespace App\Http\Requests\Api\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ScheduleRequest extends FormRequest
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
            'clinic' => 'nullable|exists:clinics,id',
            'specialization' => 'nullable|exists:specializations,id',
            'service' => 'nullable|exists:services,id',
        ];
    }

    public function messages(): array
    {
        return [
            'clinic.exists' => 'Вказана клініка не існує.',
            'specialization.exists' => 'Вказана спеціалізація не існує.',
            'service.exists' => 'Вказана послуга не існує.',
        ];
    }
}
