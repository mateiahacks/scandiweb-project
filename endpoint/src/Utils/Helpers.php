<?php 
namespace App\Utils;

class Helpers {
    public static function round_to_2_decimals ($number) {
        return number_format((float)$number, 2, '.', '');
    }
}