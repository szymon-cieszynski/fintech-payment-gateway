<?php

declare(strict_types=1);

namespace App\Client\UI\Http;

use App\Client\Application\CreateClient\CreateClientCommand;
use App\Client\Application\CreateClient\CreateClientHandler;
use App\Client\Domain\BusinessData;
use App\Client\Domain\ClientType;
use App\Client\Domain\PersonalData;
use App\Client\UI\Http\Form\BusinessForm;
use App\Client\UI\Http\Form\PersonalForm;
use http\Client\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('home/home.html.twig');
    }

    #[Route('/login', name: 'login')]
    public function login(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('home/home.html.twig');
    }
    #[Route('/new-client', name: 'register', methods: ['GET', 'POST'])]
    public function __invoke(CreateClientHandler $handler, Request $request, MessageBusInterface $messageBus): \Symfony\Component\HttpFoundation\Response
    {
        $formPersonal = $this->createForm(PersonalForm::class);
        $formBusiness = $this->createForm(BusinessForm::class);

        $formPersonal->handleRequest($request);
        $formBusiness->handleRequest($request);

        if ($formPersonal->isSubmitted() && $formPersonal->isValid())
        {
//            dd($formPersonal->getData());

            $data = $formPersonal->getData();
            $cmd = new CreateClientCommand(
                email: $data['email'],
                password: $data['password'],
                country: $data['country'],
                city: $data['city'],
                address: $data['address'],
                zipCode: $data['zipCode'],
                phoneNumber: $data['phoneNumber'],
                clientType: ClientType::personal(),
                personalData: new PersonalData($data['firstname'], $data['surname']),
                businessData: null
            );

            $messageBus->dispatch($cmd);
            return $this->redirectToRoute('home');
        }

        if ($formBusiness->isSubmitted() && $formBusiness->isValid())
        {
            $data = $formBusiness->getData();
            $cmd = new CreateClientCommand(
                email: $data['email'],
                password: $data['password'],
                country: $data['country'],
                city: $data['city'],
                address: $data['address'],
                zipCode: $data['zipCode'],
                phoneNumber: $data['phoneNumber'],
                clientType: ClientType::business(),
                personalData: null,
                businessData: new BusinessData($data['companyName'], $data['nip']),
            );

            $messageBus->dispatch($cmd);
            return $this->redirectToRoute('home');
        }
//        $cmd = new CreateClientCommand(
//            email: 'cieszynski8@gmail.com',
//            password: 'secret123',
//            country: 'Poland',
//            city: 'Warsaw',
//            address: 'Test Street 123',
//            zipCode: '00-001',
//            phoneNumber: '+48123456789',
//            clientType: ClientType::personal(),
//            personalData: $personalData = new PersonalData('Jan', 'Kowalski'),
////            businessData: $businessData = new BusinessData('MyCompanySuper', '666'),
//        );

//        return new JsonResponse($client->toArray());

        return $this->render('@Client/client/new-client.html.twig', [
            'registrationFormPersonal' => $formPersonal->createView(),
            'registrationFormBusiness' => $formBusiness->createView(),
        ]);
    }

}
