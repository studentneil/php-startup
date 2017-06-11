<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 03/05/2017
 * Time: 23:24.
 */

namespace VinylStore\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;

class SnipCartController
{
    public function getWebHookAction(Request $request, Application $app)
    {
        $webHook = $request->getContent();
        $requestBody = json_decode($webHook, true);
        var_dump($requestBody);
        $content = $requestBody['content'];
        if ($requestBody['eventName'] == 'order.completed') {
            foreach ($content['items'] as $item) {
                $count = $app['vinyl.repository']->orderCompleted($item['id']);
                $app['monolog']->info('great. '.$count.' order completed');
                $readableJson = json_encode(json_decode($webHook), JSON_PRETTY_PRINT);
                $numBytes = file_put_contents('json/orderCompleted.json', $readableJson);
                echo $count;
            }
        }
    }

    public function getShippingRatesAction(Request $request, Application $app)
    {
        $snipWebHook = $request->getContent();
        $requestBody = json_decode($snipWebHook, true);
        $content = $requestBody['content'];
        if ($requestBody['eventName'] == 'shippingrates.fetch') {

            if ($content['itemsCount'] >= 2 && $content['itemsCount'] < 3) {
                $rates = array('rates' => [array('cost' => 6, 'description' => 'standard post')]);
            } elseif ($content['itemsCount'] >= 3 && $content['itemsCount'] < 5){
                $rates = array('rates' => [array('cost' => 8, 'description' => 'standard post')]);
            }else {
                $rates = array('rates' => [array('cost' => 4, 'description' => 'standard post')]);
            }

            $responseMessage = json_encode($rates);
            $app['monolog']->info('great. shipping rates fetched and returned. you returned '.$responseMessage);
            return new Response($responseMessage, Response::HTTP_OK, array('Content-Type' => 'application/json'));
        }
    }
}
