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
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;




require_once __DIR__.'/../vendor/autoload.php';
$app = new Application();
Request::enableHttpMethodParameterOverride();

$app->register(new TwigServiceProvider(array(
    'twig.options' => array(
        'debug' => true,
    ), )));
$app->extend('twig', function ($twig, Application $app) {
    $twig->addExtension(new Twig_Extension_Debug());

    return $twig;
});
$app->register(new AssetServiceProvider());
//$app->register(new HttpFragmentServiceProvider());
//$app->register(new ServiceControllerServiceProvider());
//$app->register(new SessionServiceProvider());

//$app->register(new Silex\Provider\ValidatorServiceProvider());
//$app->register(new Silex\Provider\VarDumperServiceProvider());
//$app->register(new Silex\Provider\TranslationServiceProvider(), array(
//    'translator.domains' => array(),
//));
//$app->register(new Silex\Provider\LocaleServiceProvider());





// set up the base dir for image uploads
$app['uploads.dir'] = 'images/uploads/';
return $app;
