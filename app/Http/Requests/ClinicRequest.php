<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClinicRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:10',
            'email' => 'nullable|email|max:255',
            'specializations' => 'nullable|array',
            'specializations.*' => 'exists:specializations,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Назва клініки є обов\'язковою',
            'name.string' => 'Назва клініки повинна бути строкою',
            'name.max' => 'Назва клініки повинна бути не більше 255 символів',
            'region.string' => 'Назва регіону повинна бути строкою',
            'region.max' => 'Назва регіону повинна бути не більше 255 символів',
            'city.string' => 'Назва регіону повинна бути строкою',
            'city.max' => 'Назва міста повинна бути не більше 255 символів',
            'address.string' => 'Адреса повинна бути строкою',
            'address.max' => 'Адреса повинна бути не більше 255 символів',
            'phone_number.string' => 'Номер телефону повиннен бути строкою',
            'phone_number.max' => 'Номер телефону повиннен бути не більше 10 символів',
            'email.email' => 'Не вірний формат електронної адреси',
            'email.max' => 'Електронна адреса повинна бути не більше 255 символів',
            'specializations.array' => 'Не правильний тип для збереження',
            'specializations.exists' => 'Вибраного ключу не інує',
        ];
    }
}
