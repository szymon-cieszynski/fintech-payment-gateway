<?php

namespace App\Auth\Infrastructure\Security;

use App\Client\Domain\ClientRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthClientProvider implements UserProviderInterface
{
    public function __construct(private ClientRepository $clients)
    {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $client = $this->clients->findByEmail($identifier);
        if (!$client) {
            throw new UserNotFoundException('Client not found');
        }

        return new AuthClient($client);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return AuthClient::class === $class;
    }
}
