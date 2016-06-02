<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 02/06/2016
 * Time: 00:35
 */
namespace Art\Controllers;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MainController
{
    public function indexAction(Request $request, Application $app)
    {
        $templateName = 'home';
        $args_array = array();

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}