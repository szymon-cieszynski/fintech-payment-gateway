<?php

declare(strict_types=1);

namespace App\Client\UI\Http;

use App\Auth\Infrastructure\Security\AuthClient;
use App\Client\Application\Query\Dashboard\DashboardQuery;
use App\Client\Application\Query\Dashboard\DashboardQueryHandler;
use App\Client\Application\Query\Dashboard\DashboardView;
use App\Client\Infrastructure\Doctrine\DoctrineClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(DashboardQueryHandler $handler): Response
    {
        $user = $this->getUser(); //AuthClient security object

        if (!$user instanceof AuthClient) {
            throw $this->createAccessDeniedException();
        }

        $view = $handler(new DashboardQuery($user->getClientID()));

        return $this->render('@Client/client/dashboard.html.twig',
            [
                'view' => $view
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
