<?php

namespace App\Client\Domain;

class BusinessData
{
    public function __construct(
        private string $companyName,
        private string $nip,
    ) {
        if (empty($nip)) {
            throw new \InvalidArgumentException('NIP is required for business clients.');
        }

        if (empty($companyName)) {
            throw new \InvalidArgumentException('Company name is required for business clients.');
        }
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getNip(): string
    {
        return $this->nip;
    }
}
