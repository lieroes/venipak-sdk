<?php

namespace VenipakSDK\Service;

use VenipakSDK\Dto\ShipmentDataDto;
use VenipakSDK\Http\ApiXMLClient;

class PickupPointService
{
    private ApiXMLClient $apiClient;

    public function __construct(ApiXMLClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function importShipmentToPickupPoint(ShipmentDataDto $shipmentData, string $pickupPointId): string
    {
        $xmlPayload = $this->generateXml($shipmentData, $pickupPointId);
        $response = $this->apiClient->sendXmlRequest('/import/send_auth_basic.php', $xmlPayload);

        return $response->getBody()->getContents();
    }

    private function generateXml(ShipmentDataDto $shipmentData, string $pickupPointId): string
    {
        return <<<XML
<PickupShipment>
    <PickupPointId>{$pickupPointId}</PickupPointId>
    <RecipientName>{$shipmentData->recipientName}</RecipientName>
    <Address>{$shipmentData->address}</Address>
    <City>{$shipmentData->city}</City>
    <PostalCode>{$shipmentData->postalCode}</PostalCode>
    <Country>{$shipmentData->country}</Country>
    <Phone>{$shipmentData->phone}</Phone>
    <Email>{$shipmentData->email}</Email>
    <Weight>{$shipmentData->weight}</Weight>
</PickupShipment>
XML;
    }
}