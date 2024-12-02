<?php

namespace Tests\Unit;

use VenipakSDK\VenipakClient;
use PHPUnit\Framework\TestCase;

class VenipakClientTest extends TestCase
{
    public function testCancelShipment()
    {
        $client = new VenipakClient('https://api.venipak.com', 'test-api-key');
        $response = $client->cancelShipment('shipment12345');

        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);
    }
}