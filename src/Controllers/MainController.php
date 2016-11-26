<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 02/06/2016
 * Time: 00:35
 */
namespace DiscogsApi\Controllers;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Discogs\ClientFactory;


class MainController
{
    public function indexAction(Application $app)
    {

        $templateName = 'home';
        $args_array = array();

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function artistByIdAction(Request $request, Application $app)
    {
        $id = $request->get('id');
//        var_dump($id);
        $client = ClientFactory::factory([]);
        $name = $client->getArtist([
            'id' => $id
        ]);


//        var_dump($name);

        $templateName = 'pictures';
        $args_array = array(
            'artist' => $name
        );
        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}