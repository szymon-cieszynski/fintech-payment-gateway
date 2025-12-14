<?php

namespace App\Account\Domain;

enum Currency: string
{
    case PLN = 'PLN';
    case EUR = 'EUR';
    case USD = 'USD';
    case GBP = 'GBP';
    case CHF = 'CHF';
    case JPY = 'JPY';
    case PHP = 'PHP';
    case RUB = 'RUB';
    case AUD = 'AUD';
    case CAD = 'CAD';
    case AED = 'AED';

    public function getCode(): string
    {
        return $this->value;
    }
}
