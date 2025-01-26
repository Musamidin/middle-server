<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\ServerSenderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api', name: 'api_')]
class DashboardController extends AbstractController
{
    private ServerSenderService $_serverSenderService;

    public function __construct(ServerSenderService $serverSenderService)
    {
        $this->_serverSenderService = $serverSenderService;
    }

    #[IsGranted('ROLE_ADMIN', statusCode: 403)]
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): JsonResponse
    {
        //$result = $this->serverSender->main();
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        //$users = $userRepository->findAll();
        $message = $this->_serverSenderService->main();
        return $this->json($message);

    }
}
