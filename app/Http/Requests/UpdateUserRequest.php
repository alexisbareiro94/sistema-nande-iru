<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'razon_social' => 'sometimes',
            'ruc_ci' => 'sometimes|unique:users,ruc_ci',
            'actual_password' => 'nullable',
            'password' => ['sometimes', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/', 'confirmed'],
            'telefono' => 'sometimes',
            'email' => 'sometimes|email',
            'empresa' => 'sometimes'
        ];
    }    
}
