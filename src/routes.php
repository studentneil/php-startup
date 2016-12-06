<?php

/**
 * Created by PhpStorm.
 * User: neil
 * Date: 26/11/2016
 * Time: 00:14.
 */
$app->get('/', 'VinylStore\\Controllers\\MainController::indexAction');

$app->get('/release/{id}', 'VinylStore\\Controllers\\MainController::getReleaseByIdAction');
$app->get('/collection', 'VinylStore\\Controllers\\MainController::getCollectionAction');
