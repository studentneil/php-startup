<?php

namespace VinylStore\ServiceProviders;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use VinylStore\ImageUploader;

class UploadServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['file.uploader'] = function () {
            return new ImageUploader('uploads');
        };
    }
}
