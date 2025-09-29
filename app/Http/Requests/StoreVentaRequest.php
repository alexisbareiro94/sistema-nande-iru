<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreVentaRequest extends FormRequest
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
            'carrito' => 'required',
            'razon' => 'required',
            'ruc' => 'required',
            'total' => 'required',
            'forma_pago' => 'required',
        ];
    }

    public function messages() :array
    {
        return [
            'carrito.required' => 'Error al procesar la venta',
            'razon.required' => 'Error al procesar la venta',
            'ruc.required' => 'Error al procesar la venta',
            'total.required' => 'Error al procesar la venta',
            'forma_pago' => 'Error al procesar la venta',
        ];
    }

    public function failedValidation(Validator $validator){
        return response()->json([
            'success' => false,
            'error' => $validator->errors()->first(),
        ]);
    }
}
