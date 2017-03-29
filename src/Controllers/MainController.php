<?php

namespace VinylStore\Controllers;

use Silex\Application;

class MainController
{
    public function indexAction(Application $app)
    {
        $latestReleases = $app['vinyl.repository']->findLatestRelease();
        $randomRelease = $app['vinyl.repository']->findRandomRelease();
//        var_dump($randomRelease);
        $templateName = 'frontend/home';
        $args_array = array(
            'latest_releases' => $latestReleases,
            'random_release' => $randomRelease
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function getVinylAction(Application $app)
    {
        $collection = $app['vinyl.repository']->findEverything();

        $templateName = 'frontend/collection';
        $args_array = array(
            'collection' => $collection,

        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function getReleaseByIdAction(Application $app, $id)
    {
        $release = $app['vinyl.repository']->findOneById($id);
//        var_dump($release);
        $templateName = 'frontend/release';
        $args_array = array(
            'release' => $release,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
