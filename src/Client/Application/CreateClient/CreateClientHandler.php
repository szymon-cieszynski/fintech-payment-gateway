<?php

namespace App\Client\Application\CreateClient;

use App\Client\Domain\Client;
use App\Client\Domain\ClientRepository;
use App\Client\Domain\ClientType;

class CreateClientHandler
{
    public function __construct(
        private ClientRepository $clientRepository,
    ) {
    }

    public function __invoke(CreateClientCommand $command): Client
    {
        $client = new Client(
            $command->name,
            $command->email,
            $command->password,
            $command->country,
            $command->city,
            $command->address,
            $command->zipCode,
            $command->phoneNumber,
            ClientType::personal()
        );

        $this->clientRepository->save($client);

        return $client;
    }
}
