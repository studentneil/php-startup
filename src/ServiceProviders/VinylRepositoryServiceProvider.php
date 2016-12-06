<?php

namespace VinylStore\ServiceProviders;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use VinylStore\Repository\VinylRepository;

/**
 * Class VinylRepositoryServiceProvider.
 */
class VinylRepositoryServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['vinyl.repository'] = function () use ($app) {
            return new VinylRepository($app['db']);
        };
    }
}
