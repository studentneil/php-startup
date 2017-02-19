<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 18/02/2017
 * Time: 22:42
 */

namespace VinylStore\Controllers;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class SearchController
{
    public function searchAction(Request $request, Application $app)
    {
        $artist = $request->query->get('artist');
        $title = $request->query->get('title');
//        var_dump($artist);
//        var_dump($title);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.discogs.com/database/search?release_title='.urlencode($title).'&artist='.urlencode($artist).'&token=niKtmQLybGRjlyOlfXhuRxtNThyIjZnjQyrGltgs',
            CURLOPT_USERAGENT => 'Vinyl rug'
        ));
        $response = json_decode(curl_exec($curl));
        foreach($response->results as $release) {
            $releaseArray[] = $release;
        }
//        var_dump($response);

        curl_close($curl);
        return $app['twig']->render('frontend/search_results.html.twig', array('releases' => $releaseArray));
    }
}