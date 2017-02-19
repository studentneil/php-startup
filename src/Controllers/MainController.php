<?php

namespace VinylStore\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

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
//          return the response as a string instead of outputting it
            CURLOPT_RETURNTRANSFER => 1,
//          the url to make the call to
            CURLOPT_URL => 'https://api.discogs.com/users/rrauss/collection/folders/1/releases?token=niKtmQLybGRjlyOlfXhuRxtNThyIjZnjQyrGltgs',
//          user agent or app created in discogs
            CURLOPT_USERAGENT => 'Vinyl rug'
        ));
        $response = json_decode(curl_exec($curl));


        curl_close($curl);
//      var_dump($response);
        foreach($response->releases as $release) {
            $collectionArray[] = $release;
        }

        return $app['twig']->render('frontend/collection.html.twig', array('collection' => $collectionArray));
    }

    /**
     * Gets all the information about a single release.
     * @param Application $app
     * @param $id
     * @return mixed
     */
    public function getReleaseAction(Application $app, $id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.discogs.com/releases/'.urlencode($id).'?token=niKtmQLybGRjlyOlfXhuRxtNThyIjZnjQyrGltgs',
            CURLOPT_USERAGENT => 'Vinyl rug'
        ));
//      get the response, decode it and re-encode it to make it readable in the release.json file
        $jsonResponse = json_encode(json_decode(curl_exec($curl)), JSON_PRETTY_PRINT);
//      $numbytes holds the amount of characters saved to file
        $numBytes = file_put_contents('release.json', $jsonResponse);
//        var_dump($numBytes);
        $decodedResponse = json_decode($jsonResponse);


        curl_close($curl);

        return $app['twig']->render('frontend/release.html.twig', array(
            'release' => $decodedResponse,
            'saved' => $numBytes
            ));
    }

    public function addToCollectionAction(Request $request, Application $app)
    {
        $id = $request->request->get('id');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.discogs.com/users/rrauss/collection/folders/1/releases/'.urlencode($id).'?token=niKtmQLybGRjlyOlfXhuRxtNThyIjZnjQyrGltgs',
            CURLOPT_USERAGENT => 'Vinyl rug',
            CURLOPT_POST => 1
        ));

        $response = json_decode(curl_exec($curl));

//        var_dump($response);

        curl_close($curl);

        return $app['twig']->render('frontend/home.html.twig', array('message' => $response->instance_id));
    }

    public function deleteFromCollectionAction(Request $request, Application $app)
    {
        $instanceId = $request->request->get('instanceId');
        $releaseId = $request->request->get('releaseId');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.discogs.com/users/rrauss/collection/folders/1/releases/'.urlencode($releaseId).'/instances/'
                .urlencode($instanceId).'?token=niKtmQLybGRjlyOlfXhuRxtNThyIjZnjQyrGltgs',
            CURLOPT_USERAGENT => 'Vinyl rug',
            CURLOPT_CUSTOMREQUEST => "DELETE"
        ));
        $response = json_decode(curl_exec($curl));
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//        var_dump($http_status);
//        var_dump($response);

        curl_close($curl);

        return $app['twig']->render('frontend/home.html.twig', array('message' => $http_status));
    }

}
