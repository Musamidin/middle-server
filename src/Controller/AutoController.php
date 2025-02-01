<?php

namespace App\Controller;

use App\DTO\StoreDto;
use App\Service\ErrorFormatterService;
use App\Service\ServerSenderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route('/api', name: 'api_')]
class AutoController extends AbstractController
{
    private ValidatorInterface $_validator;
    private ErrorFormatterService $_errorService;
    private ServerSenderService $_serverSenderService;

    public function __construct(
        ValidatorInterface $validator,
        ErrorFormatterService $errorService,
        ServerSenderService $serverSenderService)
    {
        $this->_validator = $validator;
        $this->_errorService = $errorService;
        $this->_serverSenderService = $serverSenderService;
    }

    #[Route('/store', name: 'store', methods: 'POST')]
    public function Store(#[MapRequestPayload(
        acceptFormat: 'json',
        validationGroups: ['strict', 'read'],
        validationFailedStatusCode: Response::HTTP_NOT_FOUND
    )] StoreDto $request): JsonResponse
    {
        $errors = $this->_validator->validate($request);

        if (count($errors) > 0) {
            return $this->json($this->_errorService->formatValidation($errors), Response::HTTP_BAD_REQUEST);
        }
        $response = $this->_serverSenderService->sendStore($request);
        $crawler = new Crawler($response->getBody()->getContents());
        $message = $crawler->filter('#statement')->text();
        return $this->json($message);
    }
}
