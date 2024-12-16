<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FinancialReportRequest extends FormRequest
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
            'type' => 'nullable|in:analyses,services',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'clinic_id.exists' => 'Обрана клініка не існує.',
            'type.in' => 'Тип звіту має бути або "analyses" (аналізи), або "services" (послуги).',
            'start_date.date_format' => 'Дата початку повинна бути у форматі YYYY-MM-DD.',
            'end_date.date_format' => 'Дата завершення повинна бути у форматі YYYY-MM-DD.',
            'end_date.after_or_equal' => 'Дата завершення не може бути раніше дати початку.',
        ];
    }
}
