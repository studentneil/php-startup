<?php
/**
 * Date: 02/08/2017
 * Time: 22:49
 */

namespace VinylStore\Controllers;

use Silex\Application;

class RandomiseController
{
    public function randomiseAction(Application $app)
    {
        $randRelease = $app['vinyl.repository']->findRandomRelease();
        $args = array(
            'random_release' => $randRelease
        );
        return $app['twig']->render('frontend/partials/randomReleaseView.html.twig', $args);
    }
}