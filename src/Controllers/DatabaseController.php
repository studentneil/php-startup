<?php
namespace VinylStore\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use VinylStore\Forms\CreateNewReleaseType;

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
//            'releases' => $release,
        );

        return $app['twig']->render($templateName .'.html.twig', $args_array);
    }

    public function createReleaseAction(Request $request, Application $app)
    {
        $count = 0;
        $data = array(

        );
        $form = $app['form.factory']
            ->createBuilder(CreateNewReleaseType::class, $data)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $count = $app['vinyl.repository']->save($data);
        }
        $templateName = 'backend/releaseForm';
        $args_array = array(
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),
            'count' => $count
        );
        return $app['twig']->render($templateName.'.html.twig', $args_array);

    }
}
