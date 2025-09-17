<?php

namespace App\Exports;

use App\Models\MovimientoCaja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Cache;

class VentasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $ventas;
    protected $mov = false;    

    public function __construct()
    {
        $item = Cache::get('ventas');
        if (filled($item)) {
            $mov = $item->contains(function ($value) {
                return $value->venta == null;
            });
        }
        if (!filled($item) || $mov) {
            $item = Cache::remember('ventas', 20, fn() => MovimientoCaja::with('caja.user:id,name')->get());
            $this->mov = true;
            $this->ventas = $item;
        }else{
            $this->ventas = $item;
        }                
    }
    public function collection()
    {
        return $this->ventas;        
    }

    public function headings(): array
    {
        if($this->mov){
            return [
                '#',
                'Fecha',
                'Cajero',
                'Tipo',
                'Concepto',
                'Monto',
            ];
        }else{
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
        
    }

    public function map($movimiento): array
    {

        if($this->mov){
            return [
                $movimiento->id,
                format_time($movimiento->created_at),
                $movimiento->caja->user->name,
                $movimiento->tipo,
                $movimiento->concepto,
                number_format($movimiento->monto, 0, ',', '.'),
            ];
        }else{
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
}
