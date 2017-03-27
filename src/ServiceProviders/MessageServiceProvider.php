<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 27/03/2017
 * Time: 23:52
 */

namespace VinylStore\ServiceProviders;
use Pimple\ServiceProviderInterface;
use Pimple\Container;
use VinylStore\BoolFlag;

class MessageServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['message.service'] = function() use($app) {
            return new BoolFlag();
        };
    }
}