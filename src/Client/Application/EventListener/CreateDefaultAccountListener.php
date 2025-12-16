<?php

namespace App\Client\Application\EventListener;

use App\Account\Domain\Account;
use App\Account\Domain\Currency;
use App\Account\Infrastructure\Doctrine\DoctrineAccountRepository;
use App\Client\Application\Event\ClientCreated;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(ClientCreated::class)]
final class CreateDefaultAccountListener
{
    public function __construct(
        private DoctrineAccountRepository $accountRepository
    ){}

    public function __invoke(ClientCreated $event): void
    {
        $account = Account::create($event->client, Currency::fromString('PLN'));
        $this->accountRepository->save($account);
    }
}
