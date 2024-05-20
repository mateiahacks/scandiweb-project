<?php 
namespace App\Utils;

use App\Types\Currency;

class CurrencyConverter {
    public static array $rates = [
        "USD" => 1.205736,
        "GBP" => 0.866671,
        "AUD" => 1.555409,
        "JPY" => 130.210363,
        "RUB" => 91.181299
    ];

    public static array $symbols = ['$', '£', 'A$', '¥', '₽'];

    public static function get_avaible_currencies(): array {
        return [
            new Currency("USD", "$"),
            new Currency("GBP", "£"),
            new Currency("AUD", "A$"),
            new Currency("JPY", '¥'),
            new Currency("RUB", '₽')
        ];
    }

    public static function convert_from_euro($amount, $currency) {
        if (!isset(self::$rates[$currency])) {
            throw new \InvalidArgumentException("Currency not supported");
        }
        return self::$rates[$currency] * $amount;
    }

    public static function convert_to_euro($amount, $currency) {
        if (!isset(self::$rates[$currency])) {
            throw new \InvalidArgumentException("Currency not supported");
        }
        return $amount / self::$rates[$currency];
    }
}