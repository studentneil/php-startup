<?php
// ini_set('display_errors', 0);

//require_once __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../src/app.php';

if ($app['env'] === 'prod') {
    require __DIR__.'/../config/prod.php';
    require __DIR__.'/../src/routes.php';

    $app->run();
} else {
    require __DIR__.'/../config/dev.php';
    require __DIR__.'/../src/routes.php';

    $app->run();
}
