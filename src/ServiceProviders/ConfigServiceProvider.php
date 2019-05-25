<?php
declare(strict_types=1);

namespace VinylStore\ServiceProviders;

use VinylStore\Config;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    /** @var string */
    private $configFile;

    /**
     * @param \Pimple\Container $app
     */
    public function register(Container $app)
    {
        if ($app['env'] == 'prod') {
            $this->configFile = __DIR__ . '/../../config/config.ini';
        } else {
            $this->configFile = __DIR__ . '/../../config/config.dev.ini';
        }

        $app['config'] = function () {
            $config = new Config($this->configFile);
            return $config->parse();
        };
    }
}