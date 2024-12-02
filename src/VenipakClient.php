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
        try {
            $response = $this->httpClient->request($method, "{$this->baseUrl}/{$endpoint}", [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type'  => 'application/json',
                ],
                'json' => $data,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            Log::error('Venipak API request failed', [
                'endpoint' => $endpoint,
                'data' => $data,
                'error' => $e->getMessage(),
            ]);

            throw new \RuntimeException('API request failed: ' . $e->getMessage());
        }
    }

    public function registerShipment(array $shipmentData)
    {
        return $this->makeRequest('shipment/register', $shipmentData);
    }

    public function trackShipment(string $trackingId)
    {
        return $this->makeRequest("shipment/track/{$trackingId}", [], 'GET');
    }

    public function cancelShipment(string $shipmentId)
    {
        return $this->makeRequest("shipment/cancel", ['shipment_id' => $shipmentId]);
    }

    public function getShipmentDetails(string $shipmentId)
    {
        return $this->makeRequest("shipment/details/{$shipmentId}", [], 'GET');
    }

    public function listAllShipments(array $filters = [])
    {
        return $this->makeRequest("shipments", $filters, 'GET');
    }

    // Webhook Utilities

    public function verifyWebhookSignature(string $payload, string $signature, string $secret): bool
    {
        $computedSignature = hash_hmac('sha256', $payload, $secret);
        return hash_equals($computedSignature, $signature);
    }

    // Webhook Utilities

    public function verifyWebhookSignature(string $payload, string $signature, string $secret): bool
    {
        $computedSignature = hash_hmac('sha256', $payload, $secret);
        return hash_equals($computedSignature, $signature);
    }

    public function handleWebhook(array $data): array
    {
        // Process the webhook payload
        // Example: Parse shipment status update
        return $data; // Return parsed data or status
    }

    // Status Updates

    public function getShipmentStatus(string $shipmentId)
    {
        return $this->makeRequest("shipment/status/{$shipmentId}", [], 'GET');
    }

    public function updateShipmentStatus(string $shipmentId, string $status)
    {
        return $this->makeRequest("shipment/status/update", [
            'shipment_id' => $shipmentId,
            'status'      => $status,
        ]);
    }

    // Status Updates

    public function getShipmentStatus(string $shipmentId)
    {
        return $this->makeRequest("shipment/status/{$shipmentId}", [], 'GET');
    }

    public function updateShipmentStatus(string $shipmentId, string $status)
    {
        return $this->makeRequest("shipment/status/update", [
            'shipment_id' => $shipmentId,
            'status'      => $status,
        ]);
    }
}