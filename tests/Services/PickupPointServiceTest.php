<?php

namespace Services;

use PHPUnit\Framework\TestCase;
use VenipakSDK\Dto\ShipmentDataDto;
use VenipakSDK\Http\ApiXMLClient;
use VenipakSDK\Service\PickupPointService;

class PickupPointServiceTest extends TestCase
{
    public function testImportShipmentToPickupPoint(): void
    {
        $mockApiClient = $this->createMock(ApiXMLClient::class);
        $mockApiClient->expects($this->once())
            ->method('sendXmlRequest')
            ->with('/import/send_auth_basic.php', $this->stringContains('<PickupShipment>'))
            ->willReturn(new \GuzzleHttp\Psr7\Response(200, [], '<Success>OK</Success>'));

        $service = new PickupPointService($mockApiClient);

        $shipmentDto = new ShipmentDataDto(
            recipientName: 'Jane Doe',
            address: '456 Another St',
            city: 'Another City',
            postalCode: '67890',
            country: 'Country',
            phone: '0987654321',
            email: 'jane@example.com',
            weight: '5'
        );

        $response = $service->importShipmentToPickupPoint($shipmentDto, 'PICKUP123');

        $this->assertEquals('<Success>OK</Success>', $response);
    }
}