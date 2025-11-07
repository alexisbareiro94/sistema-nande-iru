<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'nombre' => 'required',
            'tipo' => 'required',
            'codigo_auto' => 'nullable',
            'codigo' => [
                'required_if:codigo_auto,false',
                Rule::unique('productos')->where(fn($q) => $q->where('tenant_id', tenant_id())),
                'nullable',
            ],
            'marca_id' => 'nullable|required_if:tipo,producto|exists:marcas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'descripcion' => 'nullable',
            'stock' => 'nullable|required_if:tipo,producto|numeric|min:0',
            'stock_minimo' => 'nullable|required_if:tipo,producto|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0.01',
            'precio_compra' => 'nullable|required_if:tipo,producto|numeric|min:0',
            'distribuidor_id' => 'nullable|required_if:tipo,producto|exists:distribuidores,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];
    }
    public function messages(): array
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'tipo.required' => 'El campo tipo es obligatorio.',
            'codigo.required' => 'El campo código es obligatorio.',
            'codigo.required_if' => 'El campo código es obligatorio.',
            'codigo.unique' => 'Este código ya está registrado en otro producto.',
            'marca_id.required_if' => 'El campo marca es obligatorio cuando el tipo es producto.',
            'marca_id.exists' => 'La marca seleccionada no existe.',
            'categoria_id.required' => 'El campo categoría es obligatorio.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'stock.required_if' => 'El campo stock es obligatorio cuando el tipo es producto.',
            'stock.numeric' => 'El stock debe ser un número.',
            'stock.min' => 'El stock no puede ser negativo.',
            'stock_minimo.required_if' => 'El campo stock mínimo es obligatorio cuando el tipo es producto.',
            'stock_minimo.numeric' => 'El stock mínimo debe ser un número.',
            'stock_minimo.min' => 'El stock mínimo no puede ser negativo.',
            'precio_venta.required' => 'El campo precio de venta es obligatorio.',
            'precio_venta.numeric' => 'El precio de venta debe ser un número.',
            'precio_venta.min' => 'El precio de venta debe ser al menos 0.01.',
            'precio_compra.required_if' => 'El campo precio de compra es obligatorio cuando el tipo es producto.',
            'precio_compra.numeric' => 'El precio de compra debe ser un número.',
            'precio_compra.min' => 'El precio de compra no puede ser negativo.',
            'distribuidor_id.required_if' => 'El campo distribuidor es obligatorio cuando el tipo es producto.',
            'distribuidor_id.exists' => 'El distribuidor seleccionado no existe.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif.',
            'imagen.max' => 'La imagen no debe pesar más de 5MB.',
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
