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

    public function checkIfEmailExist($email): bool
    {
        return $this->entityManager->getRepository(Client::class)
                ->createQueryBuilder('c')
                ->select('COUNT(c.email)')
                ->where('c.email = :email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getSingleScalarResult() > 0;
    }

    public function checkIfNIPExist(string $nip): bool
    {
        return $this->entityManager->getRepository(Client::class)
                ->createQueryBuilder('c')
                ->select('COUNT(c.businessData.nip)')
                ->where('c.businessData.nip = :nip')
                ->setParameter('nip', $nip)
                ->getQuery()
                ->getSingleScalarResult() > 0;
    }
}
