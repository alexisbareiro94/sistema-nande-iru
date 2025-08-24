<?php

namespace App\Services;

use App\Models\Categoria;
use App\Models\Marca;

class ProductService
{
    public function create_code($categoriaId, $nombre, $marcaId) {
        $categoria = Categoria::select('nombre')->where('id', $categoriaId)->first();
        $marca = Marca::select('nombre')->where('id', $marcaId)->first();

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
        $exists = Categoria::where('nombre', $resultado)->get();
        if($exists){
            $numero = $exists->count() + 1;
            $resultado = $resultado.(string)$numero;
        }

        $realCode = $cat.$resultado.$code;
        return strtolower($realCode);
    }
}
