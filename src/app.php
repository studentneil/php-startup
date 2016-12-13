<?php

/**
 * Created by PhpStorm.
 * User: neil
 * Date: 26/11/2016
 * Time: 00:00.
 */
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;

use VinylStore\ServiceProviders\VinylRepositoryServiceProvider;
use VinylStore\ServiceProviders\DatabaseManagerServiceProvider;
use VinylStore\UserProvider;

$config = parse_ini_file(realpath('../config/config.ini'), true);
$app = new Application();

$app->register(new TwigServiceProvider(array(
    'twig.options' => array(
        'debug' => true,
    ), )));
$app->extend('twig', function ($twig, Application $app) {
    $twig->addExtension(new Twig_Extension_Debug());

    return $twig;
});
$app->register(new AssetServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new Silex\Provider\VarDumperServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $config['database'],
));
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'pattern' => '^/admin',
            'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
            'logout' => array('logout_path' => '/admin/logout', 'invalidate_session' => true),
            'users' => function () use ($app) {
                 return new UserProvider($app['db']);
                    },
            )
        ),
    'security.encoder.bcrypt.cost' => 4
    )
);
$app->register(new VinylRepositoryServiceProvider());
$app->register(new DatabaseManagerServiceProvider());

return $app;
