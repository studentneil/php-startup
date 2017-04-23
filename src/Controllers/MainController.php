<?php

namespace VinylStore\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use VinylStore\Forms\RefineType;

class MainController
{
    public function indexAction(Application $app)
    {
        $latestReleases = $app['vinyl.repository']->findLatestRelease();
        $randomRelease = $app['vinyl.repository']->findRandomRelease();
        $templateName = 'frontend/home';
        $args_array = array(
            'latest_releases' => $latestReleases,
            'random_release' => $randomRelease,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function getVinylAction(Request $request, Application $app)
    {
        $limit = 8;
        $total = $app['vinyl.repository']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $paginatedReleases = $app['vinyl.repository']->findForPagination($limit, $offset);
        $refineFormData = array();
        $form = $app['form.factory']
            ->createBuilder(RefineType::class, $refineFormData)
            ->getForm();

        $templateName = 'frontend/collection';
        $args_array = array(
            'numPages' => $numPages,
            'paginatedReleases' => $paginatedReleases,

            'currentPage' => $currentPage,
            'form' => $form->createView()
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

    public function refineAction(Request $request, Application $app)
    {

        $refineFormData = array();
        $form = $app['form.factory']
            ->createBuilder(RefineType::class, $refineFormData)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $refineFormData = $form->getData();
            $refinedResults = $app['vinyl.repository']->refine($refineFormData);
        }
        $templateName = 'frontend/collectionRefined';
        $args_array = array(
            'form' => $form->createView(),
            'refinedResults' => $refinedResults,

        );
        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
