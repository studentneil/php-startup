<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 10/01/2017
 * Time: 22:30.
 */

namespace VinylStore\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use VinylStore\Forms\ImageUploadType;

class ImageController
{
    public function uploadImageAction(Request $request, Application $app)
    {
        $count = 0;
        $data = array();
        $form = $app['form.factory']
            ->createBuilder(ImageUploadType::class, $data)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $count = $app['image.repository']->save($data);
        }

        $templateName = 'backend/uploadImageForm';
        $args_array = array(
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),
            'count' => $count,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
