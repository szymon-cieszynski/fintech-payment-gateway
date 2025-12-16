<?php

namespace App\Client\Application\Query\Dashboard;

final class AccountView
{
    public function __construct(
        public readonly string $id,
        public readonly string $currency,
        public readonly int $balance,
        public readonly string $status,
        public readonly ?string $iban
    ) {}
}
