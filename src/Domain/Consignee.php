<?php

declare(strict_types=1);

namespace VenipakSDK\Domain;

use Symfony\Component\Validator\Constraints as Assert;
use VenipakSDK\Enums\Country;

class Consignee
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 60)]
    public string $name;

    #[Assert\Length(max: 16)]
    public ?string $companyCode;

    #[Assert\NotBlank]
    #[Assert\Type(type: Country::class)]
    public string $country;

    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    public string $city;

    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    public string $address;

    #[Assert\NotBlank]
    #[Assert\Regex('/^\d{4,5}$/')]
    public string $postCode;

    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    public string $contactPerson;

    #[Assert\NotBlank]
    #[Assert\Regex('/^\+\d{7,15}$/')]
    public string $contactTel;

    #[Assert\Email]
    public ?string $contactEmail;

    public function __construct(
        string $name,
        ?string $companyCode,
        string $country,
        string $city,
        string $address,
        string $postCode,
        string $contactPerson,
        string $contactTel,
        ?string $contactEmail
    ) {
        $this->name = $name;
        $this->companyCode = $companyCode;
        $this->country = $country;
        $this->city = $city;
        $this->address = $address;
        $this->postCode = $postCode;
        $this->contactPerson = $contactPerson;
        $this->contactTel = $contactTel;
        $this->contactEmail = $contactEmail;
    }
}