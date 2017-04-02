<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 28/02/2017
 * Time: 23:38.
 */

namespace VinylStore\ServiceProviders;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use VinylStore\Repository\PricingRepository;

class PricingRepositoryServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['pricing.repository'] = function () use ($app) {
            return new PricingRepository($app['db']);
        };
    }
}
