<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 27/03/2017
 * Time: 23:35.
 */

namespace VinylStore\ServiceProviders;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use VinylStore\ImageUploader;

class UploadServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['file.uploader'] = function () use ($app) {
            return new ImageUploader('uploads');
        };
    }
}
