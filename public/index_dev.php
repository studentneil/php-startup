<?php

/**
 * Created by PhpStorm.
 * User: neil
 * Date: 26/11/2016
 * Time: 00:08.
 */
use Symfony\Component\Debug\Debug;

require_once __DIR__.'/../vendor/autoload.php';
Debug::enable();
$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../config/dev.php';
require __DIR__.'/../src/routes.php';

$app->run();
