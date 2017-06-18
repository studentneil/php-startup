<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 18/06/2017
 * Time: 00:00
 */

namespace VinylStore\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use VinylStore\Forms\ContactFormType;
class ContactFormController
{
    public function contactFormAction(Request $request, Application $app)
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
}