<?php

namespace VenipakSDK\DTOs;

class PickupPointDTO
{
    public string $id;
    public string $name;
    public string $address;
    public string $city;
    public string $postalCode;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? '';
        $this->name = $data['name'] ?? '';
        $this->address = $data['address'] ?? '';
        $this->city = $data['city'] ?? '';
        $this->postalCode = $data['postalCode'] ?? '';
    }
}