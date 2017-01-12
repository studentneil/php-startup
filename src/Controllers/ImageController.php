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
use VinylStore\Entity\FileEntity;

class ImageController
{
    public function uploadImageAction(Request $request, Application $app)
    {
        $count = 0;
        $file = new FileEntity();
        $form = $app['form.factory']
            ->createBuilder(ImageUploadType::class, $file)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $image = $file->getImage();
            $fileName = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move('images/uploads/', $fileName);
            $file->setImage($fileName);
//            $imageData = $form->getData();

            $count = $app['image.repository']->save($file);
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
