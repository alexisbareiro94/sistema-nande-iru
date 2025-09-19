<?php

use Carbon\Carbon;
use App\Models\{Caja, MovimientoCaja};

if (!function_exists('format_time')) {
    function format_time($time)
    {
        return Carbon::parse($time)->format('d/m/Y - H:i');
    }
}

function moneda($monto)
{
    return number_format($monto, 0, ',', '.');
}

function generate_code()
{
    $string = 'abcdefghijklmnopqrstxywzv123456789';
    $largo = 10;
    $array = str_split($string);
    $code = '';
    for ($i = 0; $i < $largo; $i++) {
        $index = random_int(0, count($array) - 1);
        $code .= $array[$index];
    }
    return $code;
}


function crear_caja()
{    
    if(session('caja')){
        session("caja", []);
        $item = Caja::where("estado", "abierto")
        ->with("user:id,name,role")
        ->first()
        ->toArray();
        $movimientos = MovimientoCaja::where('caja_id', $item['id'])->where('tipo', 'ingreso')->get()->sum('monto');
        $egreso = MovimientoCaja::where('caja_id', $item['id'])->where('tipo', 'egreso')->get()->sum('monto');
        $saldo = $movimientos - $egreso;
        $item["saldo"] = $saldo;
        session()->put(["caja" => $item]);
    }
}
