<?php

namespace App\Client\Application\CreateClient;

use App\Client\Domain\BusinessData;
use App\Client\Domain\ClientType;
use App\Client\Domain\PersonalData;

class CreateClientCommand
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $country,
        public readonly string $city,
        public readonly string $address,
        public readonly string $zipCode,
        public readonly string $phoneNumber,
        public readonly ClientType $clientType,
        public readonly ?string $nip = null,
        public readonly ?PersonalData $personalData = null,
        public readonly ?BusinessData $businessData = null,
    ) {}
}
