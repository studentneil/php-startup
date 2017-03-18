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
use VinylStore\BoolFlag;
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
            if($count = $app['pricing.repository']->save($data)) {
                $app['session']->getFlashBag()->add('success', BoolFlag::SUCCESS);
            } else {
                $app['session']->getFlashBag()->add('failure', BoolFlag::FAILURE);
            }
        }
        $templateName = 'backend/snipDataForm';
        $args_array = array(
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),
//            'message' => $message,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}