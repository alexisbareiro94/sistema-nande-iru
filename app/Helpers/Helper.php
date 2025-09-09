<?php

use Carbon\Carbon;

if (!function_exists('format_time')) {
    function format_time($time)
    {
        return Carbon::parse($time)->format('d/m/Y - H:i');
    }
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
