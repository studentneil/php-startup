<?php

namespace VinylStore\ServiceProviders;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use VinylStore\Repository\ShippingRatesRepository;

class ShippingRatesServiceProvider implements ServiceProviderInterface
{
    /**
     * @param \Pimple\Container $app
     */
    public function register(Container $app)
    {
        $app['shipping.repository'] = function () use ($app) {
            return new ShippingRatesRepository($app['db']);
        };
    }
}