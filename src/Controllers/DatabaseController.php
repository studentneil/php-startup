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

        $column = $app['database.manager']->viewTable($table);
        $collection = $app['vinyl.repository']->findAll();
        $item = array();
        foreach ($collection as $release) {
            $item = $release;
        }
        var_dump($item);
        $templateName = 'backend/table';
        $args_array = array(
            'column' => $column,
            'release' => $release,
        );

        return $app['twig']->render($templateName .'.html.twig', $args_array);
    }
}
