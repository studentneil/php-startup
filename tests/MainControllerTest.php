<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 03/01/2017
 * Time: 22:39
 */

namespace VinylStoreTests;



use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


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
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Vinylstore for record enthusiasts")')->count());
    }

    public function testLoginLink()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }


}
