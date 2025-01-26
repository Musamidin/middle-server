<?php

namespace App\Controller;

use App\DTO\StoreDto;
use App\Service\DTOValidator;
use App\Service\RequestDTOMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class AutoController extends AbstractController
{
    private RequestDTOMapper $mapper;
    private DTOValidator $validator;

    public function __construct(RequestDTOMapper $mapper, DTOValidator $validator)
    {
        $this->mapper = $mapper;
        $this->validator = $validator;
    }

    #[Route('/store', name: 'store', methods: 'POST')]
    public function Store(Request $request): JsonResponse
    {
        // Преобразуем запрос в DTO
        $customerDTO = $this->mapper->map($request, StoreDto::class);

        // Валидируем DTO
        $this->validator->validate($customerDTO);

        return $this->json($customerDTO);
    }
}
