<?php

declare(strict_types=1);

namespace App\Client\UI\Http;

use App\Auth\Infrastructure\Security\AuthClientStub;
use App\Client\Application\CreateClient\CreateClientCommand;
use App\Client\Domain\BusinessData;
use App\Client\Domain\ClientType;
use App\Client\Domain\PersonalData;
use App\Client\Infrastructure\Doctrine\DoctrineClientRepository;
use App\Client\UI\Http\Form\BusinessForm;
use App\Client\UI\Http\Form\PersonalForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/home.html.twig');
    }

    #[Route('/new-client', name: 'register', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, MessageBusInterface $messageBus, DoctrineClientRepository $clientRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $formPersonal = $this->createForm(PersonalForm::class);
        $formBusiness = $this->createForm(BusinessForm::class);

        $formPersonal->handleRequest($request);
        $formBusiness->handleRequest($request);

        if ($formPersonal->isSubmitted() && $formPersonal->isValid()) {
            $data = $formPersonal->getData();
            $client = new AuthClientStub();
            $hashedPassword = $passwordHasher->hashPassword($client, $data['password']);
            $cmd = new CreateClientCommand(
                email: $data['email'],
                password: $hashedPassword,
                country: $data['country'],
                city: $data['city'],
                address: $data['address'],
                zipCode: $data['zipCode'],
                phoneNumber: $data['phoneNumber'],
                clientType: ClientType::personal(),
                personalData: new PersonalData($data['firstname'], $data['surname']),
                businessData: null
            );
            if ($clientRepository->checkIfEmailExist($cmd->email)) {
                $formPersonal->get('email')->addError(new FormError('Email is already taken.'));
            } else {
                $messageBus->dispatch($cmd);
                $this->addFlash('success', 'Client was successfully created.');

                return $this->redirectToRoute('home');
            }
        }

        if ($formBusiness->isSubmitted() && $formBusiness->isValid()) {
            $data = $formBusiness->getData();
            $client = new AuthClientStub();
            $hashedPassword = $passwordHasher->hashPassword($client, $data['password']);
            $cmd = new CreateClientCommand(
                email: $data['email'],
                password: $hashedPassword,
                country: $data['country'],
                city: $data['city'],
                address: $data['address'],
                zipCode: $data['zipCode'],
                phoneNumber: $data['phoneNumber'],
                clientType: ClientType::business(),
                personalData: null,
                businessData: new BusinessData($data['companyName'], $data['nip']),
            );

            $hasError = false;
            if ($clientRepository->checkIfNIPExist($data['nip'])) {
                $formBusiness->get('nip')->addError(new FormError('NIP is already taken.'));
                $hasError = true;
            }
            if ($clientRepository->checkIfEmailExist($cmd->email)) {
                $formBusiness->get('email')->addError(new FormError('Email is already taken.'));
                $hasError = true;
            }
            if (!$hasError) {
                $messageBus->dispatch($cmd);
                $this->addFlash('success', 'Client was successfully created.');

                return $this->redirectToRoute('home');
            }
        }

        return $this->render('@Client/client/new-client.html.twig', [
            'registrationFormPersonal' => $formPersonal->createView(),
            'registrationFormBusiness' => $formBusiness->createView(),
        ]);
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(): Response
    {
        return $this->render('@Client/client/dashboard.html.twig');
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
