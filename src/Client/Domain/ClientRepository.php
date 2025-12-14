<?php

namespace App\Client\Domain;

interface ClientRepository
{
    public function save(Client $client): void;

    public function checkIfEmailExist(string $email): bool;

    public function checkIfNIPExist(string $nip): bool;

    public function findByEmail(string $email): ?Client;
    public function findByID(int $id): ?Client;
}
