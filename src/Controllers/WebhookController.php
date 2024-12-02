<?php

namespace VenipakSDK\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use VenipakSDK\VenipakClient;

class WebhookController extends Controller
{
    protected VenipakClient $venipakClient;

    public function __construct(VenipakClient $venipakClient)
    {
        $this->venipakClient = $venipakClient;
    }

    public function handleWebhook(Request $request)
    {
        try {
            $payload = $request->getContent();
            $signature = $request->header('X-Venipak-Signature');
            $secret = config('venipak.webhook_secret');

            if (!$this->venipakClient->verifyWebhookSignature($payload, $signature, $secret)) {
                Log::warning('Invalid webhook signature', ['payload' => $payload]);
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            $data = json_decode($payload, true);
            $processedData = $this->venipakClient->handleWebhook($data);

            Log::info('Webhook processed successfully', ['data' => $processedData]);
            return response()->json(['success' => true, 'data' => $processedData]);

        } catch (\Exception $e) {
            Log::error('Webhook processing failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }
}