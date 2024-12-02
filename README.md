# Venipak SDK for Laravel

A PHP SDK to interact with the Venipak API, designed for easy integration with Laravel.

## Features
- Register shipments
- Track shipments
- Manage webhook notifications
- Cancel shipments and update statuses

## Requirements
- PHP >= 7.4
- Laravel >= 8.x
- Composer

## Installation
1. Add the SDK to your project using Composer:
   ```
   composer require lieroes/venipak-sdk
   ```
3. Publish the configuration file:
   ```
   php artisan vendor:publish --provider="VenipakSDK\VenipakServiceProvider"
   ```
4. Add the following environment variables to your .env file:
   ```
   VENIPAK_BASE_URL=https://api.venipak.com
   VENIPAK_API_KEY=your_api_key
   VENIPAK_WEBHOOK_SECRET=your_webhook_secret
   ```
## Usage
- Register a Shipment
```
use Venipak;

$response = Venipak::registerShipment([
    'receiver' => 'John Doe',
    'address' => '123 Main St, City',
    'country' => 'LT',
    'phone' => '+37012345678',
]);

if ($response['success']) {
    echo "Shipment registered with ID: " . $response['data']['id'];
}
```

- Handle Webhooks
Define a webhook route in your web.php:
```
Route::post('/webhooks/venipak', [WebhookController::class, 'handleWebhook']);
```

## Testing
Run PHPUnit tests to validate SDK functionality:
vendor/bin/phpunit

## Contributing
Pull requests are welcome. For significant changes, please open an issue first to discuss what you would like to change.

## License
This project is licensed under the MIT License.
