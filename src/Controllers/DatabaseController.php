<?php
namespace VinylStore\Controllers;

use Silex\Application;

Class DatabaseController
{
    public function indexAction(Application $app)
    {
        $tables = $app['database.manager']->getTables();
        
        $size = sizeof($tables);
        $count = $app['vinyl.repository']->getCount();
        $templateName = 'backend/database';
        $args_array = array(
            'size' => $size,
            'tables' => $tables,
            'count' => $count,
        );

        return $app['twig']->render($templateName .'.html.twig', $args_array);
    }
}
