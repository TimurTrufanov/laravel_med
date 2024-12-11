<?php

namespace App\Http\Requests\Api\Doctor;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends BaseFormRequest
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
            'medical_history' => 'nullable|required_with:treatment,diagnosis_id,custom_diagnosis|string|max:5000',
            'treatment' => 'nullable|required_with:medical_history,diagnosis_id,custom_diagnosis|string|max:5000',
            'diagnosis_id' => 'nullable|exists:diagnoses,id',
            'custom_diagnosis' => 'nullable|string|max:255',

            'analyses' => 'nullable|array',
            'analyses.*.analysis_id' => 'required|exists:analyses,id',
            'analyses.*.quantity' => 'required|integer|min:1|max:20',
            'analyses.*.recommended_date' => 'nullable|date|date_format:Y-m-d|after_or_equal:today',

            'services' => 'nullable|array',
            'services.*.service_id' => 'required|exists:services,id',
            'services.*.quantity' => 'required|integer|min:1|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'medical_history.required_with' => 'Поле "Історія хвороби" є обов’язковим при заповнені картки.',
            'medical_history.string' => 'Поле "Історія хвороби" має бути текстовим.',
            'medical_history.max' => 'Поле "Історія хвороби" не може перевищувати 5000 символів.',
            'treatment.required_with' => 'Поле "Лікування" є обов’язковим при заповнені картки.',
            'treatment.string' => 'Поле "Лікування" має бути текстовим.',
            'treatment.max' => 'Поле "Лікування" не може перевищувати 5000 символів.',
            'diagnosis_id.exists' => 'Вказаний діагноз недійсний.',
            'custom_diagnosis.string' => 'Поле "Власний діагноз" має бути текстовим.',
            'custom_diagnosis.max' => 'Поле "Власний діагноз" не може перевищувати 255 символів.',


            'analyses.*.analysis_id.required' => 'Поле "Аналіз" є обов’язковим.',
            'analyses.*.analysis_id.exists' => 'Обраний аналіз не існує.',
            'analyses.*.quantity.required' => 'Поле "Кількість" є обов’язковим.',
            'analyses.*.quantity.integer' => 'Поле "Кількість" має бути цілим числом.',
            'analyses.*.quantity.min' => 'Поле "Кількість" має бути щонайменше 1.',
            'analyses.*.quantity.max' => 'Поле "Кількість" має бути не більше 20.',
            'analyses.*.recommended_date.date' => 'Рекомендована дата має бути у форматі дати',
            'analyses.*.recommended_date.date_format' => 'Рекомендована дата має бути у форматі YYYY-MM-DD.',
            'analyses.*.recommended_date.after_or_equal' => 'Рекомендована дата не може бути в минулому.',

            'services.*.service_id.required' => 'Поле "Послуга" є обов’язковим.',
            'services.*.service_id.exists' => 'Обрана послуга не існує.',
            'services.*.quantity.required' => 'Поле "Кількість" є обов’язковою.',
            'services.*.quantity.integer' => 'Поле "Кількість" має бути цілим числом.',
            'services.*.quantity.min' => 'Поле "Кількість" має бути щонайменше 1.',
            'services.*.quantity.max' => 'Поле "Кількість" має бути не більше 20.',
        ];
    }
}
