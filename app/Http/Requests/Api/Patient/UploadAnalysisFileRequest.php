<?php

namespace App\Http\Requests\Api\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadAnalysisFileRequest extends FormRequest
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
            'file' => 'required|file|mimes:pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Поле файл є обов\'язковим.',
            'file.file' => 'Файл повинен бути дійсним файлом.',
            'file.mimes' => 'Файл повинен мати формат PDF.',
            'file.max' => 'Розмір файлу не повинен перевищувати 2 МБ.',
        ];
    }
}
