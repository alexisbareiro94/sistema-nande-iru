<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AbrirCajaRequest extends FormRequest
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
            'monto_inicial' => 'required|numeric|min:0',            
        ];
    }

    public function messages() : array
    {
        return [
            'monto_inicial.required' => 'Debes Agregar un monto de apertura',
            'monto_inicial.numeric' => 'Debes Ingresar un numero',
            'monto_inicial.min' => 'El monto debe ser mayor a 0',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->with('error', $validator->errors()->first());
    }
}
