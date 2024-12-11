<?php

namespace App\Http\Requests;

use App\Rules\CheckDaySheetOverlap;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DaySheetRequest extends FormRequest
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
        $doctorId = $this->input('doctor_id');
        $startTime = $this->input('start_time');
        $endTime = $this->input('end_time');
        $daySheetId = $this->route('day_sheet')?->id;

        return [
            'doctor_id' => 'required|exists:doctors,id',
            'date' => [
                'required',
                'date',
                'after_or_equal:today',
                new CheckDaySheetOverlap($doctorId, $startTime, $endTime, $daySheetId),
            ],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Виберіть лікаря.',
            'doctor_id.exists' => 'Обраний лікар не існує.',
            'clinic_id.required' => 'Необхідно обрати клініку.',
            'clinic_id.exists' => 'Обрана клініка не існує.',
            'date.required' => 'Поле "Дата" є обов\'язковим.',
            'date.date' => 'Поле "Дата" має бути у форматі дати.',
            'date.after_or_equal' => 'Дата має бути сьогодні або у майбутньому.',
            'start_time.required' => 'Поле "Час початку" є обов\'язковим.',
            'start_time.date_format' => 'Поле "Час початку" має бути у форматі ЧЧ:ХХ.',
            'end_time.required' => 'Поле "Час завершення" є обов\'язковим.',
            'end_time.date_format' => 'Поле "Час завершення" має бути у форматі ЧЧ:ХХ.',
            'end_time.after' => 'Поле "Час завершення" має бути пізніше "Часу початку".',
        ];
    }
}
