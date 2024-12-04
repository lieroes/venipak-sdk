<?php

declare(strict_types=1);

namespace VenipakSDK\Domain;

use Symfony\Component\Validator\Constraints as Assert;

class Pack
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 14)]
    public string $packNo;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(0)]
    public float $weight;

    #[Assert\GreaterThan(0)]
    public ?float $volume;

    public function __construct(string $packNo, float $weight, ?float $volume = null)
    {
        $this->packNo = $packNo;
        $this->weight = $weight;
        $this->volume = $volume;
    }
}