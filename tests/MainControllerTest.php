<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 03/01/2017
 * Time: 22:39
 */

namespace VinylStoreTests;


use VinylStore\Controllers\MainController;
use Silex\WebTestCase;


class MainControllerTest extends WebTestCase

{


    public function createApplication()
    {
        $app = require __DIR__ . '/../src/app.php';
        require __DIR__ . '/../config/dev.php';
        require __DIR__ . '/../src/routes.php';
        $app['session.test'] = true;
        return $this->app = $app;
    }

    public function testMainController()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/home');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Vinyl Store")')->count()
        );

    }
}
