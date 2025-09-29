<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateCajaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        return $user->role === 'admin' || $user->role === 'caja' || $user->role = 'personal';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'monto_cierre' => 'required|numeric',
            'diferencia' => 'required|numeric',
            'observaciones' => 'nullable|string',
            'saldo_esperado' => 'required',
            'egreso' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'monto_cierre.requires' => 'El monto de cierre es obligatorio',
            'monto_cierre.numeric' => 'El monto debe ser un numero',
            'diferencia.required' => 'La diferencia es obligatoria',
            'saldo_esperado.required' => 'El saldo esperado es obligatorio'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
