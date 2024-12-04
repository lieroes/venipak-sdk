<?php

namespace VenipakSDK\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class ApiXMLClient
{
    private Client $client;

    public function __construct(string $baseUrl, string $username, string $password)
    {
        $this->client = new Client([
            'base_uri' => $baseUrl,
            'auth' => [$username, $password],
            'headers' => [
                'Content-Type' => 'text/xml',
            ],
        ]);
    }

    public function sendXmlRequest(string $endpoint, string $xmlPayload): ResponseInterface
    {
        try {
            return $this->client->post($endpoint, [
                'body' => $xmlPayload,
            ]);
        } catch (RequestException $e) {
            throw new \RuntimeException('Request failed: ' . $e->getMessage());
        }
    }
}