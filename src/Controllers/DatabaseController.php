<?php
namespace VinylStore\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

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

    public function viewTableAction(Application $app, $table)
    {
        $columnNames  = $app['database.manager']->viewColumnNames($table);
        $details = $app['database.manager']->viewTable($table);
        
        $templateName = 'backend/table';
        $args_array = array(
            'columnNames' => $columnNames,
            'details' => $details,
            'releases' => $release,
        );

        return $app['twig']->render($templateName .'.html.twig', $args_array);
    }
}
