<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        $formattedErrors = [];

        foreach ($errors as $key => $messages) {
            $keys = explode('.', $key);
            $temp = &$formattedErrors;

            foreach ($keys as $index) {
                if (!isset($temp[$index])) {
                    $temp[$index] = [];
                }
                $temp = &$temp[$index];
            }

            $temp = $messages;
        }

        throw new HttpResponseException(response()->json(['errors' => $formattedErrors], 422));
    }
}
