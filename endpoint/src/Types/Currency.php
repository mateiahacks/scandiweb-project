<?php 
namespace App\Types;

class Currency {
    private string $label;
    private string $symbol;

    // constructor
    public function __construct(string $label, string $symbol) {
        $this->label = $label;
        $this->symbol = $symbol;
    }

    public function get_label(): string { return $this->label; }
    public function get_symbol(): string { return $this->symbol; } 
    
}