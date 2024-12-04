<?php
declare(strict_types=1);

namespace VenipakSDK\Infrastructure;

use SimpleXMLElement;

class ShipmentXmlGenerator
{
    public function generate(array $shipmentData): string
    {
        $xml = new SimpleXMLElement('<description type="4"/>');
        $manifest = $xml->addChild('manifest');
        $manifest->addAttribute('title', $shipmentData['manifest']['title']);
        $manifest->addAttribute('show_shipment_no', $shipmentData['manifest']['show_shipment_no']);

        foreach ($shipmentData['shipments'] as $shipment) {
            $shipmentNode = $manifest->addChild('shipment');
            $this->addEntity($shipmentNode, 'consignee', $shipment['consignee']);
            $this->addEntity($shipmentNode, 'sender', $shipment['sender']);
            $this->addEntity($shipmentNode, 'attribute', $shipment['attribute']);
            foreach ($shipment['packs'] as $pack) {
                $this->addEntity($shipmentNode, 'pack', $pack);
            }
        }

        return $xml->asXML();
    }

    private function addEntity(SimpleXMLElement $parent, string $entityName, array $entityData): void
    {
        $entity = $parent->addChild($entityName);
        foreach ($entityData as $key => $value) {
            $entity->addChild($key, htmlspecialchars((string)$value));
        }
    }
}