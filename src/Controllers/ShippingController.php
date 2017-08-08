<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 08/08/2017
 * Time: 23:04
 */

namespace VinylStore\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use VinylStore\Forms\ShippingRatesType;

class ShippingController
{

    public function viewShippingRatesAction(Application $app)
    {
        $ratesData = $app['shipping.repository']->viewAll();
        $templateName = 'backend/viewShipping';
        $args_array = array(
            'allRates' => $ratesData,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    public function shippingRatesAction(Request $request, Application $app)
    {
        $data = array();
        $form = $app['form.factory']
            ->createBuilder(ShippingRatesType::class, $data)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $shippingRatesData = $form->getData();
            if ($count = $app['shipping.repository']->save($shippingRatesData)) {
                $app['session']->getFlashBag()->add('success', $app['message.service']->getPricingDataAdded());
            } else {
                $app['session']->getFlashBag()->add('failure', $app['message.service']->getPricingNotAdded());
            }
        }
        return $app['twig']->render('backend/shipping.html.twig', array('form' => $form->createView()));
    }


    public function editShippingRatesAction(Request $request, Application $app, $quantity)
    {
        $data = $app['shipping.repository']->findOneById($quantity);
        $form = $app['form.factory']
            ->createBuilder(ShippingRatesType::class, $data)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            if ($count = $app['shipping.repository']->editRates($data, $quantity)) {
                $app['session']->getFlashBag()->add('success', $app['message.service']->getPricingDataAdded());
            } else {
                $app['session']->getFlashBag()->add('failure', $app['message.service']->getPricingNotAdded());
            }
        }
        return $app['twig']->render('backend/shipping.html.twig', array('form' => $form->createView()));
    }
}