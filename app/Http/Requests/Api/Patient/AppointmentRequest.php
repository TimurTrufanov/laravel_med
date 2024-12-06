<?php

namespace App\Http\Requests\Api\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends FormRequest
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
            'time_sheet_id' => 'required|exists:time_sheets,id',
            'service_id' => 'required|exists:services,id',
        ];
    }

    public function messages(): array
    {
        return [
            'time_sheet_id.required' => 'Виберіть час запису',
            'time_sheet_id.exists' => 'Обраний час не існує',
            'service_id.required' => 'Виберіть послугу запису',
            'service_id.exists' => 'Обрана послуга не існує',
        ];
    }
}
