<?php

namespace VinylStore\Controllers;

use Exception;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use VinylStore\Forms\CreateNewReleaseType;

class ReleaseController
{
    /**
     * @param \Silex\Application $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getReleasesAction(Application $app)
    {
        $releases = $app['vinyl.repository']->findAll();
        $template = 'backend/releases';
        $args = array(
            'releases' => $releases
        );
        return $app['twig']->render($template .'.html.twig', $args);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Silex\Application $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createReleaseAction(Request $request, Application $app)
    {
        $form = $this->submitReleaseForm($request, $app);

        $templateName = 'backend/partials/releaseForm';
        $args_array = array(
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),

        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Silex\Application $app
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editReleaseAction(Request $request, Application $app, $id)
    {
        $releaseData = $app['vinyl.repository']->findReleaseForEdit($id);
        $form = $app['form.factory']
            ->createBuilder(CreateNewReleaseType::class, $releaseData)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            if (!$app['vinyl.repository']->editRelease($data, $id)) {
                $app['session']->getFlashBag()->add('failure', $app['message.service']->getReleaseNotEdited());
            }
            $app['session']->getFlashBag()->add('success', $app['message.service']->getReleaseEdited());
        }

        return $app['twig']->render('backend/partials/releaseForm.html.twig',
            [
                'user' => $app['session']->get('user'),
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Silex\Application $app
     * @return \Symfony\Component\Form\Form
     */
    public function submitReleaseForm(Request $request, Application $app)
    {
        $repository = $app['vinyl.repository'];
        $form = $this->getReleaseForm($app, []);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            try {
                /** @var \VinylStore\Repository\VinylRepository $repository */
                $repository->save($data);
                $app['session']->getFlashBag()->add('success', $app['message.service']->getReleaseCreated());
            } catch (Exception $e) {
                $app['session']->getFlashBag()->add('failure', $app['message.service']->getReleaseNotCreated());
            }
        }

        return $form;
    }

    /**
     * @param \Silex\Application $app
     * @return mixed
     */
    public function showReleaseFormAction(Application $app)
    {
        $form = $this->getReleaseForm($app, []);

        return $app['twig']->render('backend/partials/releaseForm.html.twig',
            [
                'user' => $app['session']->get('user'),
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param \Silex\Application $app
     * @param array $data
     * @return mixed
     */
    private function getReleaseForm(Application $app, array $data)
    {
        $form = $app['form.factory']
            ->createBuilder(CreateNewReleaseType::class, $data)
            ->getForm();

        return $form;
    }
}
