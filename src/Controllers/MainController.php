<?php

namespace VinylStore\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

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
            'random_release' => $randomRelease,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function getVinylAction(Request $request, Application $app)
    {
        $limit = 5;
        $total = $app['vinyl.repository']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $paginatedReleases = $app['vinyl.repository']->findForPagination($limit, $offset);
//        $collection = $app['vinyl.repository']->findEverything();

        $templateName = 'frontend/collection';
        $args_array = array(
            'numPages' => $numPages,
            'paginatedReleases' => $paginatedReleases,
            'currentPage' => $currentPage

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
