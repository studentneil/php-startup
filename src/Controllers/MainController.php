<?php

namespace VinylStore\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VinylStore\Forms\ContactFormType;
use VinylStore\Forms\RefineType;
use VinylStore\Paginator;

class MainController
{
    const RELEASES_PER_PAGE = 12;

    /**
     * @param Application $app
     * @return Response
     */
    public function indexAction(Application $app)
    {
        $rockReleases = $app['vinyl.repository']->getReleasesByGenre('rock', '2', '0');
        $electronicReleases = $app['vinyl.repository']->getReleasesByGenre('electronic', '2', '0');
        $classicRockReleases = $app['vinyl.repository']->getReleasesByGenre('classic-rock', '2', '0');
        $randomRelease = $app['vinyl.repository']->findRandomRelease();
        $templateName = 'frontend/home';
        $args_array = array(
            'rock_releases' => $rockReleases,
            'elec_releases' => $electronicReleases,
            'classic_releases' => $classicRockReleases,
            'random_release' => $randomRelease
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return Response
     */
    public function getVinylAction(Request $request, Application $app)
    {
        $total = $app['vinyl.repository']->getActiveReleasesCount();
        list($pager, $offset, $limit) = $this->configurePagination($request, $total);
        $paginatedReleases = $app['vinyl.repository']->findForPagination($limit, $offset);

        $templateName = 'frontend/collection';
        $args_array = array(
            'numPages' => $pager->getNumPages(),
            'results' => $paginatedReleases,
            'currentPage' => $pager->getCurrentPage()
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * Retrieves and sorts a list of vinyls by genres.
     *
     * @param Request $request
     * @param Application $app
     * @param $genre one of {rock, electronic, classic rock}
     *
     * @return template: collection.html.twig
     */
    public function getGenreAction(Request $request, Application $app, $genre)
    {
        $total = $app['vinyl.repository']->getActiveReleaseByGenre($genre);
        list($pager, $offset, $limit) = $this->configurePagination($request, $total);
        $results = $app['vinyl.repository']->getReleasesByGenre($genre, $limit, $offset);

        $templateName = 'frontend/collection';
        $args_array = array(
            'numPages' => $pager->getNumPages(),
            'currentPage' => $pager->getCurrentPage(),
            'genre' => $genre,
            'results' => $results
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * Gets an individual vinyl release by its id.
     *
     * @param Application $app
     * @param int         $id
     *
     * @return template: release.html.twig
     */
    public function getReleaseByIdAction(Application $app, $id)
    {
        $safeId = trim(filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $release = $app['vinyl.repository']->findOneById($safeId);
        $templateName = 'frontend/release';
        $args_array = array(
            'release' => $release,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * Processes the refine form and retrieves the refined results.
     * If the form isnt filled in, it redirects back to getVinylAction.
     *
     * @param Request     $request
     * @param Application $app
     *
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

    public function faqAction(Application $app)
    {
        $args_array = array();
        $templateName = 'frontend/faq';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function contactAction(Request $request, Application $app)
    {
        $contactFormData = array();
        $form = $app['form.factory']
            ->createBuilder(ContactFormType::class, $contactFormData)
            ->getForm();

        $templateName = 'frontend/contact';
        $args_array = array(
            'form' => $form->createView()
        );
        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    public function renderRefineFormAction(Application $app)
    {
        $formData = array();
        $form = $app['form.factory']
            ->createBuilder(RefineType::class, $formData)
            ->getForm();

        return $app['twig']->render('frontend/partials/refineForm.html.twig', array('form' => $form->createView()));
    }

    public function randomiseAction(Request $request, Application $app)
    {

    }

    /**
     * @param Request $request
     * @param $total
     * @return array
     */
    private function configurePagination(Request $request, $total): array
    {
        $pager = new Paginator(self::RELEASES_PER_PAGE, $total);
        $pager->setCurrentPage($request->get('page', 1));
        $offset = $pager->getOffset();
        $limit = $pager->getLimit();

        return array($pager, $offset, $limit);
    }
}
