<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->role, ['admin', 'caja', 'personal']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'surname' => 'nullable|string',
            'razon_social' => 'required|string',
            'ruc_ci' => 'required|string',
            'email' => 'nullable|email',
            'telefono' => 'nullable|numeric'
        ];
    }

    public function messages() :array
    {
        return [
            'name.string' => 'El nombre tiene que ser una cadena de string',
            'surname.string' => 'El apellido tiene que ser un cadena de string',
            'razon_social.required' => 'Tienes que completar el campo Razón Social',
            'razon_social.string' =>'La rozon social debe ser un cadena de texto',
            'ruc_ci.required' => 'Tienes que completar el campo Ruc o CI',
            'ruc_ci.string' => 'El ruc o ci tiene que ser una cadena de texto',
        ];        
    }

    public function failedValidation(Validator $validator){
        return response()->json([
            'success' => false,
            'error' => $validator->errors()->first(),
        ]);
    }
}
