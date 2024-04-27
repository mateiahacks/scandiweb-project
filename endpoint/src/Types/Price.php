<?php 
namespace App\Types;

class Price {
    private int $amount;
    private Currency $currency;

    public function __construct(int $amount, Currency $currency) {
        $this->amount = $amount;
        $this->currency = $currency;
    }
    
    public function get_amount(): int { return $this->amount; } 
    public function get_currency(): Currency { return $this->currency; }
}