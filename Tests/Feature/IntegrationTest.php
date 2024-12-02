<?php

namespace Tests\Feature;

use Tests\TestCase;
use Venipak;

class IntegrationTest extends TestCase
{
    public function testRegisterShipment()
    {
        $shipmentData = [
            'receiver' => 'John Doe',
            'address' => '123 Main St',
            'country' => 'LT',
            'phone' => '+37012345678',
        ];

        $response = Venipak::registerShipment($shipmentData);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('success', $response);
    }
}