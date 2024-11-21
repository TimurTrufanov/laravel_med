<?php

namespace App\Http\Requests\DaySheet;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'doctor_id' => 'required|exists:doctors,id',
            'clinic_id' => 'required|exists:clinics,id',
            'day_of_week' => [
                'required',
                Rule::in(['Понеділок', 'Вівторок', 'Середа', 'Четвер', 'Пʼятниця', 'Субота', 'Неділя']),
                Rule::unique('day_sheets')->where(function ($query) {
                    return $query->where('doctor_id', $this->doctor_id)
                        ->where('day_of_week', $this->day_of_week)
                        ->where('id', '!=', $this->route('day_sheet')->id);
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Виберіть лікаря',
            'doctor_id.exists' => 'Обраний лікар не існує',
            'clinic_id.required' => 'Необхідно обрати клініку',
            'clinic_id.exists' => 'Обрана клініка не існує',
            'day_of_week.required' => 'Виберіть день тижня',
            'day_of_week.in' => 'Обраний день тижня є недійсним',
            'day_of_week.unique' => 'Розклад для обраного лікаря на цей день вже існує',
        ];
    }
}
