<?php

namespace App\Client\Domain;

class Client
{
    private ?int $id = null;

    public function __construct(
        private string $email,
        private string $password,
        private string $country,
        private string $city,
        private string $address,
        private string $zipCode,
        private string $phoneNumber,
        private ClientType $clientType,
        private ?PersonalData $personalData = null,
        private ?BusinessData $businessData = null,
        private \DateTimeImmutable $createdAt = new \DateTimeImmutable(),
    ) {
        if ($clientType->isPersonal()) {
            if (null === $personalData) {
                throw new \InvalidArgumentException('Personal clients require firstname and surname.');
            }
            if (null !== $businessData) {
                throw new \InvalidArgumentException('Personal clients must not have business data.');
            }
        }

        if ($clientType->isBusiness()) {
            if (null === $businessData) {
                throw new \InvalidArgumentException('Business clients require company name and NIP.');
            }
            if (null !== $personalData) {
                throw new \InvalidArgumentException('Business clients must not have personal data.');
            }
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
            'email' => $this->email,
            'password' => $this->password,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'zipCode' => $this->zipCode,
            'phoneNumber' => $this->phoneNumber,
            'clientType' => $this->clientType->getValue(),
            'businessData' => $this->businessData?->getCompanyName(), // nullsafe operator if businessData is null
            'personalData' => $this->personalData?->getFullname(),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getHashedPassword(): string
    {
        return $this->password;
    }
}
