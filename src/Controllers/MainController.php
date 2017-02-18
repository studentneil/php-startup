<?php

namespace VinylStore\Controllers;

use Silex\Application;


class MainController
{

    /**
     * Home page.
     * @param Application $app
     * @return mixed
     */
    public function indexAction(Application $app)
    {
        $templateName = 'frontend/home';
        $args_array = array();

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * Get all the releases in my discogs collection.
     * @param Application $app
     */
    public function collectionAction(Application $app)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.discogs.com/users/rrauss/collection/folders/1/releases?token=niKtmQLybGRjlyOlfXhuRxtNThyIjZnjQyrGltgs',
            CURLOPT_USERAGENT => 'Vinyl rug'
        ));
        $response = json_decode(curl_exec($curl));


        curl_close($curl);
//        dump($response);
        foreach($response->releases as $release) {
            $collectionArray[] = $release;
        }

        return $app['twig']->render('frontend/collection.html.twig', array('collection' => $collectionArray));
    }

    public function getReleaseAction(Application $app, $id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.discogs.com/releases/'.$id.'?token=niKtmQLybGRjlyOlfXhuRxtNThyIjZnjQyrGltgs',
            CURLOPT_USERAGENT => 'Vinyl rug'
        ));
        $response = json_decode(curl_exec($curl));
//        var_dump($response);

        curl_close($curl);

        return $app['twig']->render('frontend/release.html.twig', array('release' => $response));
    }

}
