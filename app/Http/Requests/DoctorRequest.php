<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . optional($this->doctor)->user_id,
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|string|in:чоловічий,жіночий',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|size:10|regex:/^\d{10}$/',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            'clinic_id' => 'required|exists:clinics,id',
            'appointment_duration' => 'required|integer|min:5|max:60|multiple_of:5',
            'position' => 'required|string|max:255',
            'bio' => 'required|string|max:5000',

            'specializations' => 'nullable|array',
            'specializations.*' => 'exists:specializations,id',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Ім\'я є обов\'язковим.',
            'first_name.string' => 'Ім\'я повинно бути строкою.',
            'first_name.max' => 'Ім\'я не може перевищувати 255 символів.',

            'last_name.required' => 'Прізвище є обов\'язковим.',
            'last_name.string' => 'Прізвище повинно бути строкою.',
            'last_name.max' => 'Прізвище не може перевищувати 255 символів.',

            'email.required' => 'Електронна адреса є обов\'язковою.',
            'email.email' => 'Введіть дійсну електронну адресу.',
            'email.unique' => 'Електронна адреса вже використовується.',

            'date_of_birth.date' => 'Дата народження повинна бути дійсною датою.',
            'date_of_birth.before' => 'Дата народження повинна бути в минулому.',

            'gender.string' => 'Стать повинна бути строкою.',
            'gender.in' => 'Стать повинна бути або чоловічою або жіночою',

            'address.string' => 'Адреса повинна бути строкою.',
            'address.max' => 'Адреса не може перевищувати 255 символів.',

            'phone_number.string' => 'Номер телефону повинен бути строкою.',
            'phone_number.size' => 'Номер телефону повинен містити рівно 10 цифр.',
            'phone_number.regex' => 'Номер телефону повинен містити лише цифри від 0 до 9.',

            'photo.image' => 'Файл повинен бути зображенням.',
            'photo.mimes' => 'Допустимі формати зображень: jpeg, png, jpg.',
            'photo.max' => 'Розмір файлу не повинен перевищувати 2 МБ.',

            'clinic_id.required' => 'Клініка є обов\'язковою.',
            'clinic_id.exists' => 'Обрана клініка не існує.',

            'appointment_duration.required' => 'Тривалість прийому є обов\'язковою.',
            'appointment_duration.integer' => 'Тривалість прийому повинна бути цілим числом.',
            'appointment_duration.min' => 'Тривалість прийому не може бути меншою за 5 хвилин.',
            'appointment_duration.max' => 'Тривалість прийому не може перевищувати 60 хвилин.',
            'appointment_duration.multiple_of' => 'Тривалість прийому повинна бути кратною 5.',

            'position.required' => 'Посада є обов\'язковою.',
            'position.string' => 'Посада повинна бути строкою.',
            'position.max' => 'Посада не може перевищувати 255 символів.',

            'bio.required' => 'Біографія є обов\'язковою.',
            'bio.string' => 'Біографія повинна бути строкою.',
            'bio.max' => 'Біографія не може перевищувати 5000 символів.',

            'specializations.array' => 'Спеціалізації повинні бути масивом.',
            'specializations.*.exists' => 'Одна або більше обраних спеціалізацій не існують.',
        ];
    }
}
