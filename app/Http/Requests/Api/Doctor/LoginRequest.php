<?php

namespace App\Http\Requests\Api\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string|min:16',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Введіть email',
            'email.email' => 'Введіть дійсну адресу електронної пошти.',
            'password.required' => 'Введіть пароль',
            'password.min' => 'Пароль повинен містити щонайменше 16 символів.',
        ];
    }
}
