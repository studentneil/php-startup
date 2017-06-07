<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 07/06/2017
 * Time: 22:43
 */

namespace VinylStore\ServiceProviders;

use VinylStore\Config;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['config'] = function () use ($app) {
            $file = __DIR__.'/../../config/config.ini';
            $config = new Config($file);
            return $config->parse();
        };
    }
}