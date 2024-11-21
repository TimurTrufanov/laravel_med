<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TimeSheetRequest extends FormRequest
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
            'day_sheet_id' => 'required|exists:day_sheets,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ];
    }

    public function messages(): array
    {
        return [
            'day_sheet_id.required' => 'Поле є обов\'язковим для заповнення.',
            'day_sheet_id.exists' => 'Обраний розклад не існує.',
            'start_time.required' => 'Поле є обов\'язковим для заповнення.',
            'start_time.date_format' => 'Поле має бути у форматі ЧЧ:ХХ.',
            'end_time.required' => 'Поле є обов\'язковим для заповнення.',
            'end_time.date_format' => 'Поле має бути у форматі ЧЧ:ХХ.',
            'end_time.after' => 'Поле "Час завершення" має бути пізніше "Часу початку".',
        ];
    }
}
