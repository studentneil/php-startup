<?php

namespace VinylStore\ServiceProviders;

use VinylStore\Repository\EventsRepository;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class EventsRepositoryServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['events.repository'] = function () use ($app) {

            return new EventsRepository($app['db']);
        };
    }
}