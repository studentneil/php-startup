<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 28/02/2017
 * Time: 22:56
 */

namespace VinylStore\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use VinylStore\Forms\AddPricingDataType;

class PricingController
{


    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function indexAction(Request $request, Application $app)
    {
        $count = 0;
        $data = array();
        $choices = $app['vinyl.repository']->fillChoicesWithReleaseId();
        foreach ($choices as $choice) {
            $id[] = $choice->getId();
            $title[] = $choice->getTitle();
        }

        $form = $app['form.factory']
            ->createBuilder(AddPricingDataType::class, $data, array('id' => $id, 'title' => $title))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $count = $app['pricing.repository']->save($data);
        }

        $templateName = 'backend/snipDataForm';
        $args_array = array(
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),
            'count' => $count,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}