<?php

/**
 * Created by PhpStorm.
 * User: neil
 * Date: 01/06/2016
 * Time: 23:35.
 */

$app = require __DIR__.'/../src/app.php';
$app['debug'] = true;
require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/routes.php';

$app->run();

