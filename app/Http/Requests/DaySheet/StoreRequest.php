<?php

namespace App\Http\Requests\DaySheet;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'doctor_ids' => 'required|array',
            'doctor_ids.*' => 'exists:doctors,id',
            'clinic_id' => 'required|exists:clinics,id',
            'days_of_week' => 'required|array',
            'days_of_week.*' => Rule::in(['Понеділок', 'Вівторок', 'Середа', 'Четвер', 'Пʼятниця', 'Субота', 'Неділя']),
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_ids.required' => 'Виберіть хоча б одного лікаря',
            'doctor_ids.*.exists' => 'Обраний лікар не існує',
            'clinic_id.required' => 'Необхідно обрати клініку',
            'clinic_id.exists' => 'Обрана клініка не існує',
            'days_of_week.required' => 'Виберіть хоча б один день тижня',
            'days_of_week.*.in' => 'Обраний день тижня є недійсним',
        ];
    }
}
