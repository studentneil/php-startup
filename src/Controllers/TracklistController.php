<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 05/05/2017
 * Time: 23:10
 */

namespace VinylStore\Controllers;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class TracklistController
{
    public function getTracklistAction(Application $app, $catno, $artist, $title)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.discogs.com/database/search?type=release&release_title='.urlencode($title).'&catno='
                .str_replace(' ', '', $catno)
            .'&token=niKtmQLybGRjlyOlfXhuRxtNThyIjZnjQyrGltgs',
            CURLOPT_USERAGENT => 'Vinyl rug'
        ));
        $response = json_decode(curl_exec($curl));

        foreach($response->results as $release) {
            $id = $release->id;
        }
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.discogs.com/releases/'.urlencode($id).'?token=niKtmQLybGRjlyOlfXhuRxtNThyIjZnjQyrGltgs',
            CURLOPT_USERAGENT => 'Vinyl rug'
        ));
//      get the response, decode it and re-encode it to make it readable in the release.json file
        $jsonResponse = curl_exec($curl);
        $readableJson = json_encode(json_decode($jsonResponse), JSON_PRETTY_PRINT);
        $numBytes = file_put_contents('json/release.json', $readableJson);
        $decodedResponse = json_decode($jsonResponse);
        curl_close($curl);
        return $app['twig']->render('frontend/partials/tracklist.html.twig', array('release' => $decodedResponse));
    }
}