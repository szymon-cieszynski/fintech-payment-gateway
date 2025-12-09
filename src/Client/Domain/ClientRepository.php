<?php

namespace App\Client\Domain;

interface ClientRepository
{
    public function save(Client $client): void;

    public function checkIfEmailExist(int $id): bool;

    public function checkIfNIPExist(string $nip): bool;
}
