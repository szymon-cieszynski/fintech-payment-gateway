<?php

declare(strict_types=1);

namespace App\Client\UI\Http;

use App\Auth\Infrastructure\Security\AuthClient;
use App\Client\Infrastructure\Doctrine\DoctrineClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(DoctrineClientRepository $clientRepository): Response
    {
        $user = $this->getUser(); //AuthClient security object

        if (!$user instanceof AuthClient) {
            throw $this->createAccessDeniedException();
        }

        $client = $user->getClient();

        $clientData = $client->clientType->isBusiness()
            ? $client->businessData->companyName
            : $client->personalData->firstname;


        $userViaDoctrine = $clientRepository->findByID($user->getClientID());
        $accounts = $userViaDoctrine->getAccounts();

        return $this->render('@Client/client/dashboard.html.twig',
            [
                'client' => $clientData,
                'accounts' => $accounts
            ]
        );
    }

    #[Route('/payments', name: 'payments')]
    public function payments(): Response
    {
        return $this->render('home/home.html.twig');
    }

    #[Route('/trades', name: 'trades')]
    public function trades(): Response
    {
        return $this->render('home/home.html.twig');
    }

    #[Route('/reports', name: 'reports')]
    public function reports(): Response
    {
        return $this->render('home/home.html.twig');
    }
}
