<?php

namespace App\Exports;

use App\Models\MovimientoCaja;
use illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VentasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $ventas;

    public function __construct()
    {   
        if(session('ventas')){
            $this->ventas = session('ventas');
        }else{
            $this->ventas = MovimientoCaja::all();
        }
    }
    public function collection()
    {           
        return $this->ventas;
    }

    public function headings(): array
    {
        return [
            'movimiento id',
            'caja id',
            'venta id',
            'fecha',            
            'cliente',
            'productos',
            'cantidad',
            'monto',

        ];
    }

    public function map($movimiento) :array{
        return [
            $movimiento->id,
            $movimiento->caja_id,
            $movimiento->venta_id,
            $movimiento->created_at,
            $movimiento->venta->cliente->razon_social ?? '',
            $movimiento->venta->productos->pluck('nombre') ?? '',
            $movimiento->venta->detalleVentas->pluck('cantidad') ?? '',
            $movimiento->monto,            
        ];
    }
}
