<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdatePersonalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [            
            'name' => 'sometimes',
            'email' => 'sometimes',
            'role' => 'sometimes', // prox feat: preguntar si existe por id
            'salario' => 'sometimes',
            'activo' => 'sometimes',
        ];
    }

    public function messages(): array
    {
        return [
            
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }
}
