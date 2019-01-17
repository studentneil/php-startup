<?php

namespace VinylStore\ServiceProviders;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use VinylStore\Repository\ImageRepository;

class ImageRepositoryServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['image.repository'] = function () use ($app) {
            return new ImageRepository($app['db']);
        };
    }
}
