<?php

namespace App\Client\Domain;

class Client
{
    private ?int $id = null;

    public function __construct(
        public readonly string             $email,
        public readonly string             $password,
        public readonly string             $country,
        public readonly string             $city,
        public readonly string             $address,
        public readonly string             $zipCode,
        public readonly string              $phoneNumber,
        public readonly ClientType         $clientType,
        public readonly ?PersonalData      $personalData = null,
        public readonly ?BusinessData      $businessData = null,
        public readonly \DateTimeImmutable $createdAt = new \DateTimeImmutable(),
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
            'businessData' => $this->businessData?->companyName, // nullsafe operator if businessData is null
            'personalData' => [
                'firstname' => $this->personalData?->firstname,
                'surname' =>  $this->personalData?->surname
            ],
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }

    public function getHashedPassword(): string
    {
        return $this->password;
    }
}
