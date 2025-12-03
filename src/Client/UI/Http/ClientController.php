<?php

declare(strict_types=1);

namespace App\Client\UI\Http;

use App\Client\Application\CreateClient\CreateClientCommand;
use App\Client\Application\CreateClient\CreateClientHandler;
use App\Client\Domain\BusinessData;
use App\Client\Domain\ClientType;
use App\Client\Domain\PersonalData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/new-client', name: 'register', methods: ['GET'])]
    public function __invoke(CreateClientHandler $handler): JsonResponse
    {
        $cmd = new CreateClientCommand(
            email: 'cieszynski8@gmail.com',
            password: 'secret123',
            country: 'Poland',
            city: 'Warsaw',
            address: 'Test Street 123',
            zipCode: '00-001',
            phoneNumber: '+48123456789',
            clientType: ClientType::personal(),
            personalData: $personalData = new PersonalData('Jan', 'Kowalski'),
//            businessData: $businessData = new BusinessData('MyCompanySuper', '666'),
        );

        $client = $handler($cmd);

        return new JsonResponse($client->toArray());
    }
}
