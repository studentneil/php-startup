<?php

namespace VinylStore\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use VinylStore\Forms\AddPricingDataType;
use VinylStore\Options;

class PricingController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Silex\Application $app
     * @return mixed
     */
    public function indexAction(Request $request, Application $app)
    {
        $data = array();
        $choices = $app['vinyl.repository']->fillChoicesWithReleaseId();
        $options = new Options($choices);
        $mergedOptions = $options->mergeChoices();

        $form = $app['form.factory']
            ->createBuilder(AddPricingDataType::class, $data, array('choices' => $mergedOptions))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            if ($count = $app['pricing.repository']->save($data)) {
                $app['session']->getFlashBag()->add('success', $app['message.service']->getPricingDataAdded());
            } else {
                $app['session']->getFlashBag()->add('failure', $app['message.service']->getPricingNotAdded());
            }
        }
        $templateName = 'backend/snipDataForm';
        $args_array = array(
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * @param \Silex\Application $app
     * @return mixed
     */
    public function viewPricingAction(Application $app)
    {
        $allPricing = $app['pricing.repository']->findAll();
        $templateName = 'backend/viewPricing';
        $args_array = array(
            'allPricing' => $allPricing,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Silex\Application $app
     * @param int $id
     * @return mixed
     */
    public function editPricingAction(Request $request, Application $app, $id)
    {
        $pricingData = $app['pricing.repository']->findOneById($id);
        $form = $app['form.factory']
            ->createBuilder(AddPricingDataType::class, $pricingData, array('choices' => [$pricingData['release_id'] => $id]))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            if ($count = $app['pricing.repository']->editPricing($data, $id)) {
                $app['session']->getFlashBag()->add('success', $app['message.service']->getPricingDataAdded());
            } else {
                $app['session']->getFlashBag()->add('failure', $app['message.service']->getPricingNotAdded());
            }
        }
        $templateName = 'backend/snipDataForm';
        $args_array = array(
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
