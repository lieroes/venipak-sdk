<?php

namespace Services;

use PHPUnit\Framework\TestCase;
use VenipakSDK\Dto\ShipmentDataDto;
use VenipakSDK\Http\ApiXMLClient;
use VenipakSDK\Service\ShipmentService;

class ShipmentServiceTest extends TestCase
{
    public function testImportShipmentData(): void
    {
        $mockApiClient = $this->createMock(ApiXMLClient::class);
        $mockApiClient->expects($this->once())
            ->method('sendXmlRequest')
            ->with('/import/send_auth_basic.php', $this->stringContains('<Shipment>'))
            ->willReturn(new \GuzzleHttp\Psr7\Response(200, [], '<Success>OK</Success>'));

        $service = new ShipmentService($mockApiClient);

        $shipmentDto = new ShipmentDataDto(
            recipientName: 'John Doe',
            address: '123 Main St',
            city: 'City',
            postalCode: '12345',
            country: 'Country',
            phone: '1234567890',
            email: 'email@example.com',
            weight: '10'
        );

        $response = $service->importShipmentData($shipmentDto);

        $this->assertEquals('<Success>OK</Success>', $response);
    }

    public function testGenerateXml(): void
    {
        $shipmentDto = new ShipmentDataDto(
            recipientName: 'John Doe',
            address: '123 Main St',
            city: 'City',
            postalCode: '12345',
            country: 'Country',
            phone: '1234567890',
            email: 'email@example.com',
            weight: '10'
        );

        $mockApiClient = $this->createMock(ApiXMLClient::class);
        $service = new ShipmentService($mockApiClient);

        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('generateXml');
        $method->setAccessible(true);

        $xml = $method->invoke($service, $shipmentDto);

        $this->assertStringContainsString('<RecipientName>John Doe</RecipientName>', $xml);
        $this->assertStringContainsString('<Weight>10</Weight>', $xml);
    }
}