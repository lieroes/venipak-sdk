<?php

declare(strict_types=1);

namespace VenipakSDK\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use GuzzleHttp\Client;
use VenipakSDK\Infrastructure\ApiXmlClient;

class DependencyInjectionConfig
{
    public static function configure(ContainerBuilder $container): void
    {
        $container
            ->register(Client::class)
            ->setPublic(true);

        $container
            ->register(ApiXmlClient::class)
            ->addArgument(new Reference(Client::class))
            ->setPublic(true);
    }
}