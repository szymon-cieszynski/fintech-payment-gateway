<?php

namespace App\Tests\Client\Domain;

use App\Client\Domain\BusinessData;
use App\Client\Domain\Client;
use App\Client\Domain\ClientType;
use App\Client\Domain\PersonalData;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testThrowsExceptionWhenPersonalDataIsEmpty(): void
    {
        $this->expectException(\DomainException::class);
        new Client(
            'test@example.com',
            'secret',
            'PL',
            'Poznań',
            'Street 1',
            '60-100',
            '123456789',
            ClientType::personal(),
            null
        );
    }

    public function testThrowsExceptionWhenBusinessDataIsEmpty(): void
    {
        $this->expectException(\DomainException::class);
        new Client(
            'test@example.com',
            'secret',
            'PL',
            'Poznań',
            'Street 1',
            '60-100',
            '123456789',
            ClientType::business(),
            null,
            null
        );
    }

    public function testThrowsExceptionWhenBusinessClientHavePersonalData(): void
    {
        $personalData = new PersonalData('John', 'Doe');
        $businessData = new BusinessData('MyCompany', '123456789');

        $this->expectException(\DomainException::class);
        new Client(
            'test@example.com',
            'secret',
            'PL',
            'Poznań',
            'Street 1',
            '60-100',
            '123456789',
            ClientType::business(),
            $personalData,
            $businessData
        );
    }
}
