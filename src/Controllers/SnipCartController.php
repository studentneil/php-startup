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
        $content = $requestBody['content'];
        if ($requestBody['eventName'] == 'order.completed') {
            foreach ($content['items'] as $item) {
                $count = $app['vinyl.repository']->orderCompleted($item['id']);
                if ($app['env'] == 'dev') {
                    $app['monolog']->info('great. '.$count.' order completed');
                }

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
            if ($content['shippingAddressCountry'] !== 'IE') {
                $error = array('errors' => ['key' => 'invalid_postal_code', 'message' => 'Sorry, I cant ship to your Country. Get in touch via the contact form if youd like to discuss further']);
                $errorMessage = json_encode($error);
                return new Response($errorMessage, Response::HTTP_OK, array('Content-Type' => 'application/json'));
            }
            $quantity = $content['itemsCount'];
            $rates = $app['shipping.repository']->findOneById($quantity);
            $shippingRates = array('rates' => [$rates]);

            $responseMessage = json_encode($shippingRates);
            if ($app['env'] == 'dev') {
                $app['monolog']->info('great. shipping rates fetched and returned. you returned '.$responseMessage);
            }

            return new Response($responseMessage, Response::HTTP_OK, array('Content-Type' => 'application/json'));
        }
    }
}
