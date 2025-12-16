<?php

namespace App\Client\Application\CreateClient;

use App\Client\Application\Event\ClientCreated;
use App\Client\Domain\Client;
use App\Client\Domain\ClientRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final readonly class CreateClientHandler
{
    public function __construct(
        private ClientRepository $clientRepository,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    #[AsMessageHandler]
    public function __invoke(CreateClientCommand $command): Client
    {
        $client = new Client(
            $command->email,
            $command->password,
            $command->country,
            $command->city,
            $command->address,
            $command->zipCode,
            $command->phoneNumber,
            $command->clientType,
            $command->personalData,
            $command->businessData,
        );

        $this->clientRepository->save($client);

        $this->eventDispatcher->dispatch(new ClientCreated($client));

        return $client;
    }
}
