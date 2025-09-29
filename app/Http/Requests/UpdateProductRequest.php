<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
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
            'nombre' => 'sometimes',
            'tipo' => 'sometimes',
            'codigo' => 'sometimes|unique:productos,codigo',
            'marca_id' => 'sometimes|exists:marcas,id',
            'categoria_id' => 'sometimes|exists:categorias,id',
            'descripcion' => 'nullable',
            'stock' => 'sometimes|nullable|numeric|min:0',
            'stock_minimo' => 'sometimes|nullable|numeric|min:0',
            'precio_venta' => 'sometimes|nullable|numeric|min:0.01',
            'precio_compra' => 'sometimes|nullable|numeric|min:0',
            'distribuidor_id' => 'sometimes|nullable|exists:distribuidores,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.unique' => 'Este código ya está registrado en otro producto.',
            'marca_id.exists' => 'La marca seleccionada no existe.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'stock.numeric' => 'El stock debe ser un número.',
            'stock.min' => 'El stock no puede ser negativo.',
            'stock_minimo.numeric' => 'El stock mínimo debe ser un número.',
            'stock_minimo.min' => 'El stock mínimo no puede ser negativo.',
            'precio_venta.numeric' => 'El precio de venta debe ser un número.',
            'precio_venta.min' => 'El precio de venta debe ser al menos 0.01.',
            'precio_compra.numeric' => 'El precio de compra debe ser un número.',
            'precio_compra.min' => 'El precio de compra no puede ser negativo.',
            'distribuidor_id.exists' => 'El distribuidor seleccionado no existe.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif.',
            'imagen.max' => 'La imagen no debe pesar más de 5MB.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }
}
