<?php

namespace App\Account\Application\AddAccount;

use App\Client\Domain\Client;

final readonly class AddAccountCommand
{
    public function __construct(
        public int   $clientID,
        public string $currency,
        public ?string  $iban = null
    ) {
    }
}
