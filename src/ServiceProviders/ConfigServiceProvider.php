<?php

namespace VinylStore\ServiceProviders;

use VinylStore\Config;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['config'] = function () {
            $file = __DIR__.'/../../config/config.ini';
            $config = new Config($file);

            return $config->parse();
        };
    }
}