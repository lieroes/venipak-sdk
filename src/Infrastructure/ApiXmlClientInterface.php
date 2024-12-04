<?php
declare(strict_types=1);

namespace VenipakSDK\Infrastructure;

interface ApiXmlClientInterface
{
    public function importShipments(string $xml): array;

    public function trackShipment(string $trackingNumber): array;

    public function sendShipmentXml(string $xml): array;
}