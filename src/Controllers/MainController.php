<?php

namespace VinylStore\Controllers;

use Silex\Application;

class MainController
{
    public function indexAction(Application $app)
    {
        $templateName = 'frontend/home';
        $args_array = array();

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function getCollectionAction(Application $app)
    {
        $collection = $app['vinyl.repository']->findAll();
        $templateName = 'frontend/collection';
        $args_array = array(
            'collection' => $collection,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function getReleaseByIdAction(Application $app, $id)
    {
        $release = $app['vinyl.repository']->findOneById($id);
        $templateName = 'frontend/release';
        $args_array = array(
            'release' => $release,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
