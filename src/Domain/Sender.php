<?php

declare(strict_types=1);

namespace VenipakSDK\Domain;

use Symfony\Component\Validator\Constraints as Assert;

class Sender
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 60)]
    public string $name;

    #[Assert\Length(max: 16)]
    public ?string $companyCode;

    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    public string $city;

    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    public string $address;

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
        string $city,
        string $address,
        string $contactPerson,
        string $contactTel,
        ?string $contactEmail
    ) {
        $this->name = $name;
        $this->companyCode = $companyCode;
        $this->city = $city;
        $this->address = $address;
        $this->contactPerson = $contactPerson;
        $this->contactTel = $contactTel;
        $this->contactEmail = $contactEmail;
    }
}