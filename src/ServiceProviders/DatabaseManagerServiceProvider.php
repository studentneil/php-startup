<?php

namespace VinylStore\ServiceProviders;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use VinylStore\DatabaseManager;

/**
 * Class DatabaseManagerServiceProvider.
 */
class DatabaseManagerServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['database.manager'] = function () use ($app) {
            return new DatabaseManager($app['db']);
        };
    }
}
