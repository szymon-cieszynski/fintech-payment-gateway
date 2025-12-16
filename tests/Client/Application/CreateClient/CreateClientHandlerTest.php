<?php

namespace App\Tests\Client\Application\CreateClient;

use App\Client\Application\CreateClient\CreateClientCommand;
use App\Client\Application\CreateClient\CreateClientHandler;
use App\Client\Domain\BusinessData;
use App\Client\Domain\ClientRepository;
use App\Client\Domain\ClientType;
use App\Client\Domain\PersonalData;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class CreateClientHandlerTest extends TestCase
{
    public function testHandlerSavesClient(): void
    {
        $repo = $this->createMock(ClientRepository::class);
        $event = $this->createMock(EventDispatcherInterface::class);
        $repo->expects($this->exactly(2))
             ->method('save');

        $handler = new CreateClientHandler($repo, $event);
        $personalData = new PersonalData('John', 'Doe');
        $businessData = new BusinessData('MyCompany', '666');

        $cmdPersonal = new CreateClientCommand(
            'test@example.com',
            'secret',
            'PL',
            'Poznań',
            'Street 1',
            '60-100',
            '123456789',
            ClientType::personal(),
            $personalData
        );

        $cmdBusiness = new CreateClientCommand(
            'test@example.com',
            'secret',
            'PL',
            'Poznań',
            'Street 1',
            '60-100',
            '123456789',
            ClientType::business(),
            null,
            $businessData
        );

        $handler($cmdPersonal);
        $handler($cmdBusiness);
    }
}
