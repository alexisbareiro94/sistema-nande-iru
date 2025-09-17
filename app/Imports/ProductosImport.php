<?php

namespace App\Imports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Producto([
            'nombre' => $row[0],
            'tipo' => $row[1],
            'codigo' => $row[2],
            'descripcion' => $row[3],
            'stock' => $row[4],
            'precio_venta' => $row[5],
            'precio_compra' => $row[6],    
        ]);
    }
}
