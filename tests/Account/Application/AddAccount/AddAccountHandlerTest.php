<?php

namespace App\Tests\Account\Application\AddAccount;

use App\Account\Application\AddAccount\AddAccountCommand;
use App\Account\Application\AddAccount\AddAccountHandler;
use App\Account\Domain\AccountRepository;
use App\Client\Domain\Client;
use App\Client\Domain\ClientRepository;
use PHPUnit\Framework\TestCase;

class AddAccountHandlerTest extends TestCase
{
    public function testHandlerSavesClient(): void
    {
        $repoAccount = $this->createMock(AccountRepository::class);
        $repoClient = $this->createMock(ClientRepository::class);
        $repoAccount->expects($this->exactly(1))
             ->method('save');

        $clientMock = $this->createMock(Client::class);
        $clientMock->method('hasAccountInCurrency')->willReturn(false);

        $repoClient->expects($this->exactly(1))
            ->method('findByID')
            ->with(99)
            ->willReturn($clientMock);

        $handler = new AddAccountHandler($repoAccount, $repoClient);

        $cmd = new AddAccountCommand(99, 'PLN');

        $handler($cmd);
    }
}
