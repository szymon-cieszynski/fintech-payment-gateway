<?php

namespace App\Client\Domain;

interface ClientRepository
{
    public function save(Client $client): void;
}
