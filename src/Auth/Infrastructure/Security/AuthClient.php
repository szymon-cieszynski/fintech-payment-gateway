<?php

namespace App\Auth\Infrastructure\Security;

use App\Client\Domain\Client; // domain
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthClient implements UserInterface, PasswordAuthenticatedUserInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getUserIdentifier(): string
    {
        return $this->client->email;
    }

    public function getRoles(): array
    {
        return ['ROLE_CLIENT'];
    }

    public function getPassword(): ?string
    {
        return $this->client->getHashedPassword();
    }

    public function eraseCredentials(): void
    {
    }

    public function getClientID(): int
    {
        return $this->client->getId();
    }
}
