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
        ValidatorInterface    $validator,
        ErrorFormatterService $errorService,
        ServerSenderService   $serverSenderService)
    {
        $this->_validator = $validator;
        $this->_errorService = $errorService;
        $this->_serverSenderService = $serverSenderService;
    }

    #[Route('/store', name: 'store', methods: 'POST')]
    public function Store(#[MapRequestPayload(
//        acceptFormat: 'multipart/form-data',
//        validationGroups: ['strict', 'read'],
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST
    )] StoreDto $store): JsonResponse
    {
        dd($store);
        $errors = $this->_validator->validate($store);

        if (count($errors) > 0) {
            return $this->json($this->_errorService->formatValidation($errors), Response::HTTP_BAD_REQUEST);
        }
        //dd($this->getUser()->getId());
        $response = $this->_serverSenderService->sendStore($store);
        if ($response["statusCode"] == 200) {
            $crawler = new Crawler($response["content"]);
            $message = $crawler->filter('#statement')->text();
            return $this->json($message);
        }

        return $this->json($response, $response['statusCode']);
    }
}

