<?php

namespace App\Http\Requests\Api\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentAnalysisRequest extends FormRequest
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
            'analysis_id' => 'required|exists:analyses,id',
            'quantity' => 'required|integer|min:1|max:20',
            'recommended_date' => 'nullable|date_format:Y-m-d',
        ];
    }

    public function messages(): array
    {
        return [
            'analysis_id.required' => 'Поле "Аналіз" є обов’язковим.',
            'analysis_id.exists' => 'Обраний аналіз не існує.',
            'quantity.required' => 'Поле "Кількість" є обов’язковим.',
            'quantity.integer' => 'Поле "Кількість" має бути цілим числом.',
            'quantity.min' => 'Поле "Кількість" має бути щонайменше 1.',
            'quantity.max' => 'Поле "Кількість" має бути не більше 20.',
            'recommended_date.date_format' => 'Рекомендована дата має бути у форматі YYYY-MM-DD.',
        ];
    }
}
