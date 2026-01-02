<?php

namespace App\Tests\Account\Application\AddAccount;

use App\Account\Application\AddAccount\AddAccountCommand;
use App\Account\Application\AddAccount\AddAccountHandler;
use App\Account\Domain\AccountRepository;
use App\Client\Domain\Client;
use App\Client\Domain\ClientRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\LockInterface;
use Symfony\Component\Lock\SharedLockInterface;

class AddAccountHandlerTest extends TestCase
{
    public function testHandlerAddAccount(): void
    {
        $repoAccount = $this->createMock(AccountRepository::class);
        $repoClient = $this->createMock(ClientRepository::class);
        $lockFactory = $this->createMock(LockFactory::class);
        $lock = $this->createMock(SharedLockInterface::class);

        $repoAccount->expects($this->exactly(1))
             ->method('save');

        $clientMock = $this->createMock(Client::class);
        $clientMock->method('hasAccountInCurrency')->willReturn(false);

        $repoClient->expects($this->exactly(1))
            ->method('findByID')
            ->with(99)
            ->willReturn($clientMock);

        $lockFactory->method('createLock')->willReturn($lock);
        $lock->method('acquire')->willReturn(true);


        $handler = new AddAccountHandler($repoAccount, $repoClient, $lockFactory);

        $cmd = new AddAccountCommand(99, 'PLN');

        $handler($cmd);
    }
}
