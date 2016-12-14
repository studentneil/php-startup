<?php

/**
 * Created by PhpStorm.
 * User: neil
 * Date: 26/11/2016
 * Time: 00:14.
 */
$app->get('/', 'VinylStore\\Controllers\\MainController::indexAction');
$app->get('/home', 'VinylStore\\Controllers\\MainController::indexAction');
$app->get('/login', 'VinylStore\\Controllers\\LoginController::loginAction');
$app->get('/release/{id}', 'VinylStore\\Controllers\\MainController::getReleaseByIdAction');
$app->get('/collection', 'VinylStore\\Controllers\\MainController::getCollectionAction');
$app->get('/admin/dashboard' , 'VinylStore\\Controllers\\LoginController::dashboardAction');
$app->get('/admin/database', 'VinylStore\\Controllers\\DatabaseController::indexAction');
$app->get('/admin/view/{table}', 'VinylStore\\Controllers\\DatabaseController::viewTableAction');
