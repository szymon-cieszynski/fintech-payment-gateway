<?php

namespace App\Account\Domain;

use DateTimeImmutable;

class Account
{
    public function __construct(
        public readonly string $id,
        public readonly int $clientID,
        public readonly int $balance = 0,
        public readonly DateTimeImmutable $createdAt = new DateTimeImmutable(),
        public readonly string $status = 'ACTIVE',
        public readonly Currency $currency,
        public readonly ?string $iban = null,
    ){}

    public static function create($clientID, Currency $currency, $iban = null): self
    {
        return new self(
            uniqid(),
            clientID: $clientID,
            balance: 0,
            currency: $currency,
            iban: $iban
        );
    }

}
