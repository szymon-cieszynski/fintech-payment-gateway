<?php

namespace App\Client\Domain;

class Client
{
    private ?int $id = null;

    public function __construct(
        private string $name,
        private string $email,
        private string $password,
        private string $country,
        private string $city,
        private string $address,
        private string $zipCode,
        private string $phoneNumber,
        private ClientType $clientType,
        private ?string $nip = null,
        private \DateTimeImmutable $createdAt = new \DateTimeImmutable(),
    ) {
        if ($clientType->isBusiness() && empty($nip)) {
            throw new \InvalidArgumentException('NIP is required for business clients.');
        }

        if ($clientType->isPersonal() && null !== $nip) {
            throw new \InvalidArgumentException('Personal clients cannot have a NIP.');
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->clientType->getValue();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'zipCode' => $this->zipCode,
            'phoneNumber' => $this->phoneNumber,
            'clientType' => $this->clientType->getValue(),
            'nip' => $this->nip,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
