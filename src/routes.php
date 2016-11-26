<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 26/11/2016
 * Time: 00:14
 */
$app->get('/', 'DiscogsApi\\Controllers\\MainController::indexAction');
$app->get('/artist', 'DiscogsApi\\Controllers\\MainController::artistByIdAction');