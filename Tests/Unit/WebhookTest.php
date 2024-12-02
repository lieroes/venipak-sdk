<?php

namespace Tests\Unit;

use VenipakSDK\VenipakClient;
use PHPUnit\Framework\TestCase;

class WebhookTest extends TestCase
{
    public function testVerifyWebhookSignature()
    {
        $client = new VenipakClient('https://api.venipak.com', 'test-api-key');
        $payload = '{"shipment_id":"12345","status":"delivered"}';
        $secret = 'test-secret';
        $validSignature = hash_hmac('sha256', $payload, $secret);

        $this->assertTrue($client->verifyWebhookSignature($payload, $validSignature, $secret));
        $this->assertFalse($client->verifyWebhookSignature($payload, 'invalid-signature', $secret));
    }

    public function testHandleWebhook()
    {
        $client = new VenipakClient('https://api.venipak.com', 'test-api-key');
        $webhookData = [
            'shipment_id' => '12345',
            'status' => 'delivered',
        ];

        $processedData = $client->handleWebhook($webhookData);

        $this->assertIsArray($processedData);
        $this->assertEquals('delivered', $processedData['status']);
    }
}