<?php

namespace App\Account\UI\Console;

use App\Account\Domain\Account;
use App\Account\Domain\Currency;
use App\Client\Domain\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'account:create',
    description: 'Creates a new account for a client'
)]
final class CreateAccountCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private ClientRepository $clientRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('clientId', InputArgument::REQUIRED, 'Client ID')
            ->addArgument('currency', InputArgument::REQUIRED, 'Currency code (e.g. PLN, EUR)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $clientId = $input->getArgument('clientId');
        $currencyCode = strtoupper($input->getArgument('currency'));

        $client = $this->clientRepository->findByID($clientId);

        if (!$client) {
            $output->writeln("Client $clientId not found");
            return Command::FAILURE;
        }

        $currency = Currency::fromString($currencyCode);
        $account = Account::create($client, $currency);

        $this->em->persist($account);
        $this->em->flush();

        $output->writeln("Account {$account->id} created for client {$client->getId()} in {$currency->value}");

        return Command::SUCCESS;

    }
}
