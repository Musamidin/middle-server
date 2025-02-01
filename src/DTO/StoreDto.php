<?php

namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

final class StoreDto
{
    #[Assert\NotBlank]
    public string $arrival_date;

    #[Assert\NotBlank]
    public string $custom;

    #[Assert\NotBlank]
    public string $vehicle_number;

    #[Assert\NotBlank]
    public string $vehicle_country;

    #[Assert\NotBlank]
    public string $vehicle_type;

    #[Assert\NotBlank]
    public string $vehicle_vin_type;

    #[Assert\NotBlank]
    public string $vehicle_vin;

    #[Assert\NotBlank]
    public string $vehicle_brand;

    #[Assert\NotBlank]
    public string $vehicle_model;

    #[Assert\NotBlank]
    public string $last_name;

    #[Assert\NotBlank]
    public string $vehicle_photo;

    #[Assert\NotBlank]
    public string $first_name;

    #[Assert\NotBlank]
    public string $middle_name;

    #[Assert\NotBlank]
    public string $personal_number;

    #[Assert\NotBlank]
    public string $driver_country;

    #[Assert\NotBlank]
    public string $identity_card_kind;

    #[Assert\NotBlank]
    public string $doc_series;

    #[Assert\NotBlank]
    public string $doc_number;

    public string $active_tab = "pills-home";

    public bool $trailer = false;

    public bool $container = false;

    public string $trailer_number;

    public string $trailer_country;

    public string $trailer_type;

    public string $trailer_vin_type;

    public string $trailer_vin;

    public string $trailer_brand;

    public string $trailer_model;

    public string $container_number;

    public string $container_country;
}
