<?php

namespace App\Client\Infrastructure\Doctrine;

use App\Client\Domain\Client;
use App\Client\Domain\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineClientRepository implements ClientRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(Client $client): void
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }
}
