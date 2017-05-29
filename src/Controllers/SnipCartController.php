<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 03/05/2017
 * Time: 23:24.
 */

namespace VinylStore\Controllers;

use Symfony\Component\HttpFoundation\Request;
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
}
