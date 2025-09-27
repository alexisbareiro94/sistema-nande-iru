<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreMovimientoRequest extends FormRequest
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
            'tipo' => 'required|in:ingreso,egreso',
            'monto' => 'required|numeric|min:0.01',
            'concepto' => 'required|string|max:255',
            'personal_id' => 'nullable'            
        ];
    }

    public function messages(): array
    {
        return [
            'tipo.required' => 'El tipo de movimiento es obligatorio.',
            'tipo.in' => 'El tipo de movimiento debe ser "ingreso" o "egreso".',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número.',
            'monto.min' => 'El monto debe ser al menos 0.01.',
            'concepto.required' => 'El concepto es obligatorio.',
            'concepto.string' => 'El concepto debe ser una cadena de texto.',
            'concepto.max' => 'El concepto no debe exceder los 255 caracteres.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return response()->json([
            'success' => false,
            'error' => $validator->errors()->first(),
        ], 422);
    }
}
