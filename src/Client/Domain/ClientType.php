<?php

namespace App\Client\Domain;

class ClientType
{
    public const PERSONAL = 'personal';
    public const BUSINESS = 'business';
    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function personal(): self
    {
        return new self(self::PERSONAL);
    }

    public static function business(): self
    {
        return new self(self::BUSINESS);
    }

    public static function from(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isBusiness(): bool
    {
        return self::BUSINESS === $this->value;
    }

    public function isPersonal(): bool
    {
        return self::PERSONAL === $this->value;
    }
}
