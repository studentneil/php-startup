<?php

namespace VinylStore\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use VinylStore\Forms\RefineType;
use VinylStore\Paginator;


/**
 * Handles all the frontend actions and rendering templates.
 *
 * Class MainController
 * @package VinylStore\Controllers
 */
class MainController
{

    /**
     * Renders the homepage with 4 latest releases and 4 random releases.
     *
     * @param Application $app
     * @return template: home
     */
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


    /**
     * The 'main' page for viewing vinyls.
     *
     * Retrieves all releases from the database and paginates.
     * Also renders the refine form so can be accessed from the vinyl page.
     *
     * @param Request $request
     * @param Application $app
     * @return template: collection.html.twig
     */
    public function getVinylAction(Request $request, Application $app)
    {
        $total = $app['vinyl.repository']->getCount();
        $pager = new Paginator(10, $total);
        $pager->setCurrentPage($request->get('page', 1));
        $offset = $pager->getOffset();
        $limit = $pager->getLimit();
        $paginatedReleases = $app['vinyl.repository']->findForPagination($limit, $offset);
        $refineFormData = array();
        $form = $app['form.factory']
            ->createBuilder(RefineType::class, $refineFormData)
            ->getForm();

        $templateName = 'frontend/collection';
        $args_array = array(
            'numPages' => $pager->getNumPages(),
            'results' => $paginatedReleases,
            'currentPage' => $pager->getCurrentPage(),
            'form' => $form->createView()
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }


    /**
     * Retrieves and sorts a list of vinyls by genres.
     * @param Application $app
     * @param $genre one of {rock, electronic, classic rock}
     * @return template: collection.html.twig
     */
    public function getGenreAction(Application $app, $genre)
    {
        $results = $app['vinyl.repository']->getReleasesByGenre($genre);
        $refineFormData = array();
        $form = $app['form.factory']
            ->createBuilder(RefineType::class, $refineFormData)
            ->getForm();

        $templateName = 'frontend/collection';
        $args_array = array(
            'results' => $results,
            'form' => $form->createView()
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }


    /**
     * Gets an individual vinyl release by its id.
     *
     * @param Application $app
     * @param int $id
     * @return template: release.html.twig
     */
    public function getReleaseByIdAction(Application $app, $id)
    {
        $release = $app['vinyl.repository']->findOneById($id);
        $templateName = 'frontend/release';
        $args_array = array(
            'release' => $release,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }


    /**
     * Processes the refine form and retrieves the refined results.
     * If the form isnt filled in, it redirects back to getVinylAction
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function refineAction(Request $request, Application $app)
    {

        $refineFormData = array();
        $form = $app['form.factory']
            ->createBuilder(RefineType::class, $refineFormData)
            ->getForm();
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            return $app->redirect('/vinyl');
        }
        if ($form->isValid()) {
            $refineFormData = $form->getData();
            $refinedResults = $app['vinyl.repository']->refine($refineFormData);
        }

        $templateName = 'frontend/collection';
        $args_array = array(
            'form' => $form->createView(),
            'results' => $refinedResults,
        );
        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
