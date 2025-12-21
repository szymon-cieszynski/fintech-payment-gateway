<?php

namespace App\Account\Application\AddAccount;

use App\Account\Domain\Account;
use App\Account\Domain\AccountRepository;
use App\Account\Domain\Currency;
use App\Client\Domain\ClientRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class AddAccountHandler
{
    public function __construct(
        private AccountRepository $accountRepository,
        private ClientRepository $clientRepository
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
