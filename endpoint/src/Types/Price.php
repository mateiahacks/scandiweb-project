<?php 
namespace App\Types;

use App\Entity\EntityBase;

class Price extends EntityBase {
    private float $amount;
    private Currency $currency;

    public function __construct(float $amount, Currency $currency) {
        $this->amount = $amount;
        $this->currency = $currency;
    }
    
    public function get_amount() { return $this->amount; } 
    public function get_currency() { return $this->currency; }
}