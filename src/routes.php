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
$app->get('/vinyl', 'VinylStore\\Controllers\\MainController::getVinylAction');
$app->get('/admin/dashboard', 'VinylStore\\Controllers\\LoginController::dashboardAction');
$app->get('/admin/database', 'VinylStore\\Controllers\\DatabaseController::indexAction');
$app->get('/admin/view/{table}', 'VinylStore\\Controllers\\DatabaseController::viewTableAction');
$app->match('/admin/create-release', 'VinylStore\\Controllers\\DatabaseController::createReleaseAction');
$app->match('/admin/upload-image', 'VinylStore\\Controllers\\ImageController::uploadImageAction');
$app->get('/admin/view-images', 'VinylStore\\Controllers\\ImageController::viewImagesAction');
