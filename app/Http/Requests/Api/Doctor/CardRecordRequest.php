<?php

namespace App\Http\Requests\Api\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CardRecordRequest extends FormRequest
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
            'medical_history' => 'required|string|max:5000',
            'treatment' => 'required|string|max:5000',
            'diagnosis_id' => 'nullable|exists:diagnoses,id',
            'custom_diagnosis' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'medical_history.required' => 'Поле "Історія хвороби" є обов’язковим.',
            'medical_history.string' => 'Поле "Історія хвороби" має бути текстовим.',
            'medical_history.max' => 'Поле "Історія хвороби" не може перевищувати 5000 символів.',
            'treatment.required' => 'Поле "Лікування" є обов’язковим.',
            'treatment.string' => 'Поле "Лікування" має бути текстовим.',
            'treatment.max' => 'Поле "Лікування" не може перевищувати 5000 символів.',
            'diagnosis_id.exists' => 'Вказаний діагноз недійсний.',
            'custom_diagnosis.string' => 'Поле "Власний діагноз" має бути текстовим.',
            'custom_diagnosis.max' => 'Поле "Власний діагноз" не може перевищувати 255 символів.',
        ];
    }
}
