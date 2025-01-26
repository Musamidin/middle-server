<?php

namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class StoreDto
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 50)]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 10, max: 15)]
    #[Assert\Regex('/^\+?[0-9]*$/', message: 'Phone number must contain only digits and an optional +')]
    public string $phone;

    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 255)]
    public string $address;
}
