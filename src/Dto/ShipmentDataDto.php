<?php

namespace VenipakSDK\Dto;

class ShipmentDataDto
{
    public function __construct(
        public string $recipientName,
        public string $address,
        public string $city,
        public string $postalCode,
        public string $country,
        public string $phone,
        public string $email,
        public string $weight
    ) {}
}