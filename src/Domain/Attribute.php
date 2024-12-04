<?php

declare(strict_types=1);

namespace VenipakSDK\Domain;

use Symfony\Component\Validator\Constraints as Assert;
use VenipakSDK\Enums\DeliveryType;

class Attribute
{
    #[Assert\NotBlank]
    #[Assert\Type(type: DeliveryType::class)]
    public string $deliveryType;

    #[Assert\GreaterThan(0)]
    public ?float $cod;

    #[Assert\NotBlank]
    #[Assert\Length(max: 200)]
    public ?string $commentText;

    public function __construct(string $deliveryType, ?float $cod, ?string $commentText)
    {
        $this->deliveryType = $deliveryType;
        $this->cod = $cod;
        $this->commentText = $commentText;
    }
}