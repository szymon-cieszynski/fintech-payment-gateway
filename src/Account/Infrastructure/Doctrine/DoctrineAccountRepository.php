<?php

namespace App\Account\Infrastructure\Doctrine;

use App\Account\Domain\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineAccountRepository implements AccountRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save($account): void
    {
        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }
}
