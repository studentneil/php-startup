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
use VinylStore\Forms\ImageUploadType;
use VinylStore\Entity\ImageEntity;
use VinylStore\Options;
use Symfony\Component\HttpKernel\KernelEvents;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class ImageController
{
    /**
     * Upload image form.
     *
     * renders the form as well as handling the upload.
     * route: match: admin/upload-image
     *
     * @param Request     $request
     * @param Application $app
     *
     * @return mixed
     */
    public function uploadImageAction(Request $request, Application $app)
    {
        $count = 0;
        $choices = $app['vinyl.repository']->fillChoicesWithReleaseId();
        $options = new Options($choices);
        $mergedOptions = $options->mergeChoices();

        $image = new ImageEntity();
        $form = $app['form.factory']
            ->createBuilder(ImageUploadType::class, $image, array('choices' => $mergedOptions))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $uploadedImage = $app['file.uploader']->upload($image);
            $app['dispatcher']->addListener(KernelEvents::TERMINATE, function () use ($uploadedImage) {
                Image::load('uploads/'.$uploadedImage->getImage())
                     ->fit(Manipulations::FIT_STRETCH, 500, 500)
                     ->save();
            });
            if (!$count = $app['image.repository']->save($image)) {
                $app['session']->getFlashBag()->add('failure', $app['message.service']->getImageSuccessMessage());
            }
            $app['session']->getFlashBag()->add('success', $app['message.service']->getImageSuccessMessage());
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
            'releases' => $releases,
        ));
    }

    /**
     * Delete an image from the filesystem and the database.
     *
     * This will be done through an ajax call
     *
     * @param Application $app
     * @param $id . The image id
     *
     * @return string
     */
    public function deleteImageAction(Application $app, $id)
    {
        $safeId = trim(filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $response = '';
//        query the db for a file entity
//        and get the actual image string
//        to pass to the delete filesystem function
//        note: do not delete from db first.
//        correct order: filesystem first, db second.
        $image = $app['image.repository']->getImageNameForDelete($safeId);
        $path = $image->getImage();
        $imagePath = $image->setImagePath($path);
        $fs = new Filesystem();
        if ($fs->exists($imagePath)) {
            try {
                $fs->remove($imagePath);
                $response .= 'Success. deleted from filesystem<br>';
            } catch (IOException $e) {
                return $e->getMessage();
            }
        }
        $count = $app['image.repository']->deleteOneById($safeId);
        if (!$count === 1) {
            $response .= 'Theres a problem with the response.';

            return $response;
        } else {
            $response .= 'Success! An image was deleted from the database.';

            return $response;
        }
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
