<?php

declare(strict_types=1);

namespace App\Client\UI\Api;

use App\Client\Application\CreateClient\CreateClientCommand;
use App\Client\Application\CreateClient\CreateClientHandler;
use App\Client\Domain\BusinessData;
use App\Client\Domain\ClientType;
use App\Client\Domain\PersonalData;
use App\Client\Infrastructure\Doctrine\DoctrineClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/api/new_client', name: 'api_client_create', methods: ['POST'])]
    public function __invoke(Request $request, MessageBusInterface $messageBus, CreateClientHandler $handler, DoctrineClientRepository $clientRepository): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        try {
            if ('business' === $payload['clientType']) {
                $cmd = new CreateClientCommand(
                    email: $payload['email'] ?? null,
                    password: $payload['password'] ?? null,
                    country: $payload['country'] ?? null,
                    city: $payload['city'] ?? null,
                    address: $payload['address'] ?? null,
                    zipCode: $payload['zipCode'] ?? null,
                    phoneNumber: $payload['phoneNumber'] ?? null,
                    clientType: ClientType::from($payload['clientType']),
                    businessData: new BusinessData($payload['companyName'], $payload['nip']),
                );
                if ($clientRepository->checkIfNIPExist($payload['nip'])) {
                    return new JsonResponse(['error' => 'NIP is already taken.'], 422);
                }
            } else {
                $cmd = new CreateClientCommand(
                    email: $payload['email'] ?? null,
                    password: $payload['password'] ?? null,
                    country: $payload['country'] ?? null,
                    city: $payload['city'] ?? null,
                    address: $payload['address'] ?? null,
                    zipCode: $payload['zipCode'] ?? null,
                    phoneNumber: $payload['phoneNumber'] ?? null,
                    clientType: ClientType::from($payload['clientType']),
                    personalData: new PersonalData($payload['firstname'], $payload['surname']),
                );
            }
            if ($clientRepository->checkIfEmailExist($cmd->email)) {
                return new JsonResponse(['error' => 'Email is already taken.'], 422);
            }
            $client = $handler($cmd);

            return new JsonResponse(['id' => $client->getId()], 201);
        } catch (\DomainException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}
