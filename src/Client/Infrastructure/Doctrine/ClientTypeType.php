<?php

// src/Client/Infrastructure/Doctrine/ClientTypeType.php

namespace App\Client\Infrastructure\Doctrine;

use App\Client\Domain\ClientType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ClientTypeType extends Type
{
    public const NAME = 'client_type';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(50)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ClientType
    {
        return ClientType::from($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof ClientType) {
            return $value->value;
        }

        throw new \InvalidArgumentException('Invalid ClientType');
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
