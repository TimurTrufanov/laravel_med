<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiagnosisRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('diagnoses')->ignore($this->route('diagnosis')),
            ],
            'description' => 'nullable|string|max:5000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Назва є обов\'язковою',
            'name.string' => 'Назва повинна бути строкою',
            'name.max' => 'Назва повинна бути не більше 255 символів',
            'name.unique' => 'Така назва вже існує',
            'description.string' => 'Опис повинен бути строкою',
            'description.max' => 'Опис повинна бути не більше 5000 символів',
        ];
    }
}
