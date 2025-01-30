<?php

namespace App\Service;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorFormatterService
{

    #[ArrayShape(['errors' => "array"])]
    public function formatValidation(ConstraintViolationListInterface $errors): array
    {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[$error->getPropertyPath()] = $error->getMessage();
        }
        return ['errors' => $errorMessages];
    }
}
