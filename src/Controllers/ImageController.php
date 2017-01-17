<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 10/01/2017
 * Time: 22:30.
 */

namespace VinylStore\Controllers;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use VinylStore\Forms\ImageUploadType;
use VinylStore\Entity\FileEntity;

class ImageController
{

    /**
     * Upload image form.
     *
     * renders the form as well as handling the upload.
     * route: match: admin/upload-image
     *
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
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
            $image->move('uploads/', $fileName);
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

    public function viewImagesAction(Application $app)
    {
        $allImages = $app['image.repository']->findAll();
        $releases = $app['vinyl.repository']->findAll();
        $template = 'backend/viewImages';

        return $app['twig']->render($template.'.html.twig', array(
            'images' => $allImages,
            'releases' => $releases
        ));
    }

    /**
     * Delete an image from the filesystem and the database.
     *
     * This will be done through an ajax call
     *
     * @param Application $app
     * @param $id . The image id.
     * @return string
     */
    public function deleteImageAction(Application $app, $id)
    {
        $image = $app['image.repository']->getImageNameForDelete($id);
        // build a string to send to the remove function
        $imagePath = 'uploads/'.$image;
        $fs = new Filesystem();
        try {
            $fs->remove($imagePath);
        } catch (IOException $e) {
            return $e->getMessage();
        }
        // try to delete an image from the db.
        // $count will be either a 1 on success or 0 on failure
        // and as this is an ajax call, we can send a string back as a response.
        $count = $app['image.repository']->deleteOneById($id);
        if (!$count === 1) {
            $response = 'Theres a problem with the response.';
            return $response;
        } else {
            $response = 'Success! An image was deleted.';
            return $response;
        };
    }

    /**
     * Attach an image to a release.
     *
     * Another ajax call.
     * Gets the imageId and the releaseId from the template and updates the
     * image table with the releaseId.
     *
     * @param Application $app
     * @param $imageId
     * @param $releaseId
     */
    public function attachImageAction(Application $app, $imageId, $releaseId)
    {
        $count = $app['image.repository']->attachImageToRelease($imageId, $releaseId);
        if (!$count === 1) {
            $response = 'Theres a problem with the response';
            return $response;
        } else {
            $response = 'Success! You have attached the image';
            return $response;
        }
    }
}
