<?php

namespace App\Client\Application\Event;

use App\Client\Domain\Client;

final readonly class ClientCreated
{
    public function __construct(
        public Client $client
    )
    {}
}
