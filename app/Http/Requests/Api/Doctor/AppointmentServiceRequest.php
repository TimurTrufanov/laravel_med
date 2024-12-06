<?php

namespace App\Http\Requests\Api\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentServiceRequest extends FormRequest
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
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'service_id.required' => 'Поле "Послуга" є обов’язковим.',
            'service_id.exists' => 'Обрана послуга не існує.',
            'quantity.required' => 'Поле "Кількість" є обов’язковою.',
            'quantity.integer' => 'Поле "Кількість" має бути цілим числом.',
            'quantity.min' => 'Поле "Кількість" має бути щонайменше 1.',
            'quantity.max' => 'Поле "Кількість" має бути не більше 20.',
        ];
    }
}
