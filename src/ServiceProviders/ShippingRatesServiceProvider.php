<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 12/06/2017
 * Time: 22:36
 */

namespace VinylStore\ServiceProviders;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use VinylStore\Repository\ShippingRatesRepository;

class ShippingRatesServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['shipping.repository'] = function () use ($app) {
            return new ShippingRatesRepository($app['db']);
        };
    }
}