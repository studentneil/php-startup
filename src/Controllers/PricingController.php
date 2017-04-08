<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 28/02/2017
 * Time: 22:56.
 */

namespace VinylStore\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use VinylStore\BoolFlag;
use VinylStore\Forms\AddPricingDataType;
use VinylStore\Options;

class PricingController
{
    /**
     * @param Request     $request
     * @param Application $app
     *
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
                $app['session']->getFlashBag()->add('success', BoolFlag::PRICING_ADDED);
            } else {
                $app['session']->getFlashBag()->add('failure', BoolFlag::PRICING_NOT_ADDED);
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
