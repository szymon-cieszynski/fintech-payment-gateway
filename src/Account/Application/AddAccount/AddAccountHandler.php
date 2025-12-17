<?php

namespace App\Account\Application\AddAccount;

use App\Account\Domain\Account;
use App\Account\Domain\Currency;
use App\Account\Infrastructure\Doctrine\DoctrineAccountRepository;
use App\Client\Infrastructure\Doctrine\DoctrineClientRepository;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class AddAccountHandler
{
    public function __construct(
        private DoctrineAccountRepository $accountRepository,
        private DoctrineClientRepository $clientRepository
    ) {
    }

    #[AsMessageHandler]
    public function __invoke(AddAccountCommand $command): Account
    {
        $currency = Currency::fromString($command->currency);
        $client = $this->clientRepository->findByID($command->clientID);

        $account = Account::create($client, $currency);
        $this->accountRepository->save($account);

        return $account;
    }
}
