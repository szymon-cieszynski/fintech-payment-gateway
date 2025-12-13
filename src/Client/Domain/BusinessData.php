<?php

namespace App\Client\Domain;

class BusinessData
{
    public function __construct(
        public readonly string $companyName,
        public readonly string $nip,
    ) {
        if (empty($nip)) {
            throw new \DomainException('NIP is required for business clients.');
        }

        if (empty($companyName)) {
            throw new \DomainException('Company name is required for business clients.');
        }
    }
}
