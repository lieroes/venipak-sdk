<?php

declare(strict_types=1);

namespace VenipakSDK\Infrastructure;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class ApiXmlClient implements ApiXmlClientInterface
{
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function importShipments(string $xml): array
    {
        // Placeholder for method, if required.
        return [];
    }

    public function trackShipment(string $trackingNumber): array
    {
        // Placeholder for method, if required.
        return [];
    }

    public function sendShipmentXml(string $xml): array
    {
        try {
            $response = $this->httpClient->post('https://go.venipak.lt/import/send_auth_basic.php', [
                'body' => $xml,
                'headers' => [
                    'Content-Type' => 'text/xml',
                    'Accept' => 'application/json',
                ],
            ]);

            return $this->parseResponse($response);
        } catch (RequestException $e) {
            $statusCode = $e->getResponse()?->getStatusCode() ?? 0;
            $message = $e->getMessage();
            throw new \RuntimeException("Failed to send shipment XML. HTTP Status: $statusCode. Error: $message");
        }
    }

    private function parseResponse(ResponseInterface $response): array
    {
        $content = (string)$response->getBody();
        $decoded = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $decoded;
    }
}