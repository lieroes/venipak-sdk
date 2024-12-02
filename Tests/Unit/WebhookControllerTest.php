<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebhookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testWebhookProcessing()
    {
        $payload = json_encode(['shipment_id' => '12345', 'status' => 'delivered']);
        $secret = config('venipak.webhook_secret');
        $signature = hash_hmac('sha256', $payload, $secret);

        $response = $this->postJson('/webhooks/venipak', json_decode($payload, true), [
            'X-Venipak-Signature' => $signature,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function testWebhookInvalidSignature()
    {
        $payload = json_encode(['shipment_id' => '12345', 'status' => 'delivered']);

        $response = $this->postJson('/webhooks/venipak', json_decode($payload, true), [
            'X-Venipak-Signature' => 'invalid-signature',
        ]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Invalid signature']);
    }
}