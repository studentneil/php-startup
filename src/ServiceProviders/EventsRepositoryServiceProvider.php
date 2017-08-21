<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 20/08/2017
 * Time: 23:06
 */

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