<?php

namespace VinylStore\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use VinylStore\BoolFlag;
use VinylStore\Forms\CreateNewReleaseType;

class ReleaseController
{
    /**
     * @param Application $app
     *
     * @return mixed
     */
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

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function viewTableAction(Application $app)
    {
        $releases = $app['vinyl.repository']->findAll();

        $templateName = 'backend/releases';
        $args_array = array(

            'releases' => $releases,

        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

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
                $app['session']->getFlashBag()->add('failure', BoolFlag::RELEASE_NOT_CREATED);
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
}
