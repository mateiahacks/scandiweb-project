<?php 
namespace App\Controller;

use App\Types\Currency;

use App\Utils\CurrencyConverter;
use App\Utils\Serializers;

class CurrencyController {

    public function get_currencies () {
        $currencies = CurrencyConverter::get_avaible_currencies();
        return array_map(fn (Currency $currency) => Serializers::currency($currency), $currencies);
    }
}
