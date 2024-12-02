<?php

namespace VenipakSDK;

use GuzzleHttp\Client;

class VenipakClient
{
    protected Client $httpClient;
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->httpClient = new Client();
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    public function makeRequest(string $endpoint, array $data = [], string $method = 'POST')
    {
        $response = $this->httpClient->request($method, "{$this->baseUrl}/{$endpoint}", [
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type'  => 'application/json',
            ],
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function registerShipment(array $shipmentData)
    {
        return $this->makeRequest('shipment/register', $shipmentData);
    }

    public function trackShipment(string $trackingId)
    {
        return $this->makeRequest("shipment/track/{$trackingId}", [], 'GET');
    }
}
