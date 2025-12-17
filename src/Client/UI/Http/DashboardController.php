<?php

declare(strict_types=1);

namespace App\Client\UI\Http;

use App\Account\Application\AddAccount\AddAccountCommand;
use App\Account\Domain\Currency;
use App\Auth\Infrastructure\Security\AuthClient;
use App\Client\Application\Query\Dashboard\DashboardQuery;
use App\Client\Application\Query\Dashboard\DashboardQueryHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
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
        $currencies = Currency::cases();

        return $this->render('@Client/client/dashboard.html.twig',
            [
                'view' => $view,
                'currencies' => $currencies
            ]
        );
    }

    #[Route('/add-account', name: 'add_account', methods: ['POST'])]
    public function addAccount(Request $request, MessageBusInterface $messageBus): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $currency = $request->request->get('currency');
        $user = $this->getUser();

        $cmd = new AddAccountCommand($user->getClientID(), $currency);
        $messageBus->dispatch($cmd);

        $this->addFlash('success', 'Account was successfully added.');
        return $this->redirectToRoute('dashboard');
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
