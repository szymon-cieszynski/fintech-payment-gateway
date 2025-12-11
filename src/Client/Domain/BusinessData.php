<?php

namespace App\Client\Domain;

class BusinessData
{
    public function __construct(
        public readonly string $companyName,
        public readonly string $nip,
    ) {
        if (empty($nip)) {
            throw new \InvalidArgumentException('NIP is required for business clients.');
        }

        if (empty($companyName)) {
            throw new \InvalidArgumentException('Company name is required for business clients.');
        }
    }
}
