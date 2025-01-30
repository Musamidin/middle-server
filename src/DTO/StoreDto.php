<?php

namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

final class StoreDto
{
    #[Assert\NotBlank(message:"Поле name не должно быть пустымм!")]
    #[Assert\Length(min: 3, max: 50)]
    public string $name;

    #[Assert\NotBlank(message:"Поле email не должно быть пустымм!")]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank(message:"Поле phone не должно быть пустымм!")]
    #[Assert\Length(min: 10, max: 15)]
    #[Assert\Regex('/^\+?[0-9]*$/', message: 'Phone number must contain only digits and an optional +')]
    public string $phone;

    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 255)]
    public string $address;
}
