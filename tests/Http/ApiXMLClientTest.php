<?php

namespace Http;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use VenipakSDK\Http\ApiXMLClient;

class ApiXMLClientTest extends TestCase
{
    public function testSendXmlRequestSuccess(): void
    {
        $mockResponse = new Response(200, [], '<Success>OK</Success>');
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('post')
            ->willReturn($mockResponse);

        $apiClient = new ApiXMLClient('https://go.venipak.lt', 'username', 'password');
        $reflection = new \ReflectionClass($apiClient);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($apiClient, $mockClient);

        $response = $apiClient->sendXmlRequest('/import/send_auth_basic.php', '<xml></xml>');

        $this->assertEquals('<Success>OK</Success>', $response->getBody()->getContents());
    }

    public function testSendXmlRequestError(): void
    {
        $this->expectException(\RuntimeException::class);

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('post')
            ->willThrowException(new \RuntimeException('Error'));

        $apiClient = new ApiXMLClient('https://go.venipak.lt', 'username', 'password');
        $reflection = new \ReflectionClass($apiClient);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($apiClient, $mockClient);

        $apiClient->sendXmlRequest('/import/send_auth_basic.php', '<xml></xml>');
    }
}