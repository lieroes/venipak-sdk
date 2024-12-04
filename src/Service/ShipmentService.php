<?php

namespace VenipakSDK\Service;

use VenipakSDK\Dto\ShipmentDataDto;
use VenipakSDK\Http\ApiXMLClient;

class ShipmentService
{
    private ApiXMLClient $apiClient;

    public function __construct(ApiXMLClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function importShipmentData(ShipmentDataDto $shipmentData): string
    {
        $xmlPayload = $this->generateXml($shipmentData);
        $response = $this->apiClient->sendXmlRequest('/import/send_auth_basic.php', $xmlPayload);

        return $response->getBody()->getContents();
    }

    private function generateXml(ShipmentDataDto $shipmentData): string
    {
        return <<<XML
<Shipment>
    <RecipientName>{$shipmentData->recipientName}</RecipientName>
    <Address>{$shipmentData->address}</Address>
    <City>{$shipmentData->city}</City>
    <PostalCode>{$shipmentData->postalCode}</PostalCode>
    <Country>{$shipmentData->country}</Country>
    <Phone>{$shipmentData->phone}</Phone>
    <Email>{$shipmentData->email}</Email>
    <Weight>{$shipmentData->weight}</Weight>
</Shipment>
XML;
    }
}