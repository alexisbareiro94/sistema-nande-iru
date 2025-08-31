<?php

use Carbon\Carbon;

if (! function_exists('format_time')) {
    function format_time($time) {
        return Carbon::parse($time)->format('H:i - d/m/Y');
    }
}
