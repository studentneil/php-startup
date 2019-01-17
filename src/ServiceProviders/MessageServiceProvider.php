<?php

namespace VinylStore\ServiceProviders;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use VinylStore\MessageService;

class MessageServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['message.service'] = function () {
            return new MessageService();
        };
    }
}
