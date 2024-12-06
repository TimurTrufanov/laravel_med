<?php

namespace App\Http\Requests\Api\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|string|in:чоловічий,жіночий',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|size:10|regex:/^\d{10}$/',
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

            'email.required' => 'Введіть email',
            'email.email' => 'Введіть дійсну адресу електронної пошти.',
            'email.unique' => 'Користувач з таким email вже існує.',

            'password.required' => 'Введіть пароль',
            'password.min' => 'Пароль повинен містити щонайменше 8 символів.',
            'password.confirmed' => 'Паролі не співпадають.',

            'date_of_birth.date' => 'Дата народження повинна бути дійсною датою.',
            'date_of_birth.before' => 'Дата народження повинна бути в минулому.',

            'gender.string' => 'Стать повинна бути строкою.',
            'gender.in' => 'Стать повинна бути або чоловічою або жіночою',

            'address.string' => 'Адреса повинна бути строкою.',
            'address.max' => 'Адреса не може перевищувати 255 символів.',

            'phone_number.string' => 'Номер телефону повинен бути строкою.',
            'phone_number.size' => 'Номер телефону повинен містити рівно 10 цифр.',
            'phone_number.regex' => 'Номер телефону повинен містити лише цифри від 0 до 9.',
        ];
    }
}
