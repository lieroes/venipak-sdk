<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use VenipakSDK\DependencyInjection\DependencyInjectionConfig;
use VenipakSDK\Domain\Consignee;
use VenipakSDK\Domain\Sender;
use VenipakSDK\Domain\Attribute;
use VenipakSDK\Domain\Pack;
use VenipakSDK\Infrastructure\ShipmentXmlGenerator;
use VenipakSDK\Infrastructure\ApiXmlClient;

// Конфигурируем DI-контейнер
$container = new ContainerBuilder();
DependencyInjectionConfig::configure($container);
$container->compile();

/** @var ApiXmlClient $apiClient */
$apiClient = $container->get(ApiXmlClient::class);

// Создаем данные для отправки
$consignee = new Consignee(
    name: 'John Doe',
    companyCode: '123456',
    country: 'LT',
    city: 'Vilnius',
    address: 'Gedimino pr. 1',
    postCode: '12345',
    contactPerson: 'John Doe',
    contactTel: '+37061234567',
    contactEmail: 'john.doe@example.com'
);

$sender = new Sender(
    name: 'Sender Company',
    companyCode: '654321',
    city: 'Kaunas',
    address: 'Laisves al. 10',
    contactPerson: 'Jane Doe',
    contactTel: '+37064567890',
    contactEmail: 'jane.doe@example.com'
);

$attribute = new Attribute(
    deliveryType: 'nwd',
    cod: 50.0,
    commentText: 'Handle with care'
);

$packs = [
    new Pack(packNo: 'V12345E0000001', weight: 5.0, volume: 0.1),
    new Pack(packNo: 'V12345E0000002', weight: 3.0, volume: 0.05),
];

// Генерация XML
$shipmentXmlGenerator = new ShipmentXmlGenerator();
$shipmentData = [
    'manifest' => [
        'title' => '12345120429001',
        'show_shipment_no' => '1',
    ],
    'shipments' => [
        [
            'consignee' => (array) $consignee,
            'sender' => (array) $sender,
            'attribute' => (array) $attribute,
            'packs' => array_map(fn($pack) => (array) $pack, $packs),
        ],
    ],
];
$xml = $shipmentXmlGenerator->generate($shipmentData);
header('Content-Type: application/xml; charset=utf-8');
print_r($xml);
exit();
// Отправка XML в API
try {
    $response = $apiClient->sendShipmentXml($xml);
    echo "Shipment sent successfully: ".json_encode($response, JSON_PRETTY_PRINT);
} catch (\RuntimeException $e) {
    echo "Error: ".$e->getMessage();
}
