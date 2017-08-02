<?php

namespace VinylStore\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use VinylStore\Forms\CreateNewReleaseType;

class ReleaseController
{

    /**
     * Create a new release and save to the db.
     *
     * @param Request $request
     * @param Application $app
     * @return template: releaseForm.html.twig
     */
    public function createReleaseAction(Request $request, Application $app)
    {
        $data = array();
        $form = $app['form.factory']
            ->createBuilder(CreateNewReleaseType::class, $data)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            if (!$app['vinyl.repository']->save($data)) {
                $app['session']->getFlashBag()->add('failure', $app['message.service']->getReleaseNotCreated());
            }
            $app['session']->getFlashBag()->add('success', $app['message.service']->getReleaseCreated());
        }

        $templateName = 'backend/releaseForm';
        $args_array = array(
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),

        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }


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

        $templateName = 'backend/releaseForm';
        $args_array = array(
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),

        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
