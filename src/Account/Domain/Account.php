<?php

namespace App\Account\Domain;

use App\Client\Domain\Client;
use DateTimeImmutable;

class Account
{
    public function __construct(
        public readonly string $id,
        public readonly Client $client,
        public readonly int $balance = 0,
        public readonly DateTimeImmutable $createdAt = new DateTimeImmutable(),
        public readonly string $status = 'ACTIVE',
        public readonly Currency $currency,
        public readonly ?string $iban = null,
    ){}

    public static function create(Client $client, Currency $currency, $iban = null): self
    {
        return new self(
            uniqid(),
            client: $client,
            balance: 0,
            createdAt: new DateTimeImmutable(),
            status: 'ACTIVE',
            currency: $currency,
            iban: $iban
        );
    }

}
