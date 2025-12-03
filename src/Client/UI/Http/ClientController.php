<?php

declare(strict_types=1);

namespace App\Client\UI\Http;

use App\Client\Application\CreateClient\CreateClientCommand;
use App\Client\Application\CreateClient\CreateClientHandler;
use App\Client\Domain\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/new-client', name: 'register', methods: ['GET'])]
    public function __invoke(CreateClientHandler $handler): JsonResponse
    {
        $cmd = new CreateClientCommand(
            name: 'Simon Cieszynski',
            email: 'cieszynski8@gmail.com',
            password: 'secret123',
            country: 'Poland',
            city: 'Warsaw',
            address: 'Test Street 123',
            zipCode: '00-001',
            phoneNumber: '+48123456789',
            clientType: ClientType::personal()
        );

        $client = $handler($cmd);

        return new JsonResponse($client->toArray());
    }
}
