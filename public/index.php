<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 01/06/2016
 * Time: 23:35
 */
// ini_set('display_errors', 0);

require_once __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../src/app.php';
$app['env'] = 'dev';
if ($app['env'] === 'prod') {
	require __DIR__ . '/../config/prod.php';
	require __DIR__ . '/../src/routes.php';

	$app->run();

} else {
	require __DIR__ . '/../config/dev.php';
	require __DIR__ . '/../src/routes.php';

	$app->run();
}
