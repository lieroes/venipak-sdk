<?php

use VenipakSDK\Controllers\WebhookController;

Route::post('/webhooks/venipak', [WebhookController::class, 'handleWebhook']);