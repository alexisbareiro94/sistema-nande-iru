<?php

namespace App\Services;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;

class ProductService
{
    public function create_code($categoriaId, $nombre, $marcaId)
    {           
        try {
            $categoria = Categoria::select('nombre')->where('id', $categoriaId)->first() ?? 'Sin Categoria';
            $marca = Marca::select('nombre')->where('id', $marcaId)->first() ?? 'Sin Marca';
            //$nombre = 'cubierta 175/70R14';

            $splitMarca = collect(str_split($marca->nombre));

            if ($splitMarca->contains(' ')) {
                $spaceIndex = $splitMarca->search(fn($char) => $char === ' ');
                $code = $splitMarca->first() . $splitMarca[$spaceIndex + 1];
            } else {
                $code = $splitMarca->take(2)->implode('');
            }
            $cat = collect(str_split($categoria->nombre))->take(2)->implode('');
            if (preg_match('/\d/', $nombre)) {
                $resultado = preg_replace('/\D/', '', $nombre);
            } else {
                $resultado = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ]/u', '', $nombre);
            }
            $realCode = $cat . $resultado . $code;
            $exists = Producto::where('tipo', 'servicio')->get();
            $codePrueba = (string)strtolower($realCode);
            $proExists = Producto::where('codigo', $codePrueba)->first();
            if ($exists && $proExists && $proExists->tipo == 'servicio') {
                $nro = count($exists);
                $nro += 1;
                $resultadodos = $resultado . $nro;
                $realCode = $cat . $resultadodos . $code;
            }

            if ($proExists && $proExists->tipo == 'producto') {
                $chars = range(0, 100);
                $add =  collect($chars)->random(2)->implode('');
                $realCode = $cat . $resultado . $add . $code;
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'en' => 'el service']);
        }
        return strtolower($realCode);
    }
}
