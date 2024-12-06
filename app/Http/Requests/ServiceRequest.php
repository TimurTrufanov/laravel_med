<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0|max:999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'specialization_id' => 'required|exists:specializations,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Назва є обов\'язковою',
            'name.string' => 'Назва повинна бути строкою',
            'name.max' => 'Назва повинна бути не більше 255 символів',
            'description.string' => 'Опис повинен бути строкою',
            'description.max' => 'Опис повинна бути не більше 5000 символів',
            'price.required' => 'Ціна є обов\'язковою.',
            'price.numeric' => 'Ціна повинна бути числом.',
            'price.min' => 'Ціна не може бути меншою за 0.',
            'price.max' => 'Ціна не може перевищувати 999999.99.',
            'price.regex' => 'Ціна може містити не більше двох знаків після коми.',
            'specialization_id.required' => 'Спеціалізація є обов\'язковою.',
            'specialization_id.exists' => 'Обрана спеціалізація не існує.',
        ];
    }
}
