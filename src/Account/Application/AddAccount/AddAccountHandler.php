<?php

namespace App\Account\Application\AddAccount;

use App\Account\Domain\Account;
use App\Account\Domain\AccountRepository;
use App\Account\Domain\Currency;
use App\Client\Domain\ClientRepository;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class AddAccountHandler
{
    public function __construct(
        private AccountRepository $accountRepository,
        private ClientRepository $clientRepository,
        private LockFactory $accountCreationLockFactory
    ) {
    }

    #[AsMessageHandler]
    public function __invoke(AddAccountCommand $command): Account
    {
        $lock = $this->accountCreationLockFactory->createLock('account_creation' . $command->clientID, 5);

        try {
            if (!$lock->acquire()) {
                throw new \RuntimeException('Account creation already in progress.');
            }
            $currency = Currency::fromString($command->currency);
            $client = $this->clientRepository->findByID($command->clientID);
            $account = Account::create($client, $currency);
            $this->accountRepository->save($account);

            return $account;
        }
        finally {
                $lock->release();
        }
    }
}
