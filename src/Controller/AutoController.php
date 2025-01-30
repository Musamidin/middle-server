<?php

namespace App\Controller;

use App\DTO\StoreDto;
use App\Service\ErrorFormatterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function __construct(ValidatorInterface $validator, ErrorFormatterService $errorService)
    {
        $this->_validator = $validator;
        $this->_errorService = $errorService;
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
        return $this->json($request);
    }
}
