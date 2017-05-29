<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 19/03/2017
 * Time: 21:01
 */

namespace VinylStoreTests;

use Silex\WebTestCase;


class LoginControllerTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../src/app.php';
        require __DIR__ . '/../config/dev.php';
        require __DIR__ . '/../src/routes.php';
        $app['session.test'] = true;
        return $this->app = $app;
    }

    public function testLoginFormForBadCredentials()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        // select the submit button from the login form
        $form = $crawler
        // note: you have to use the actual text value of the button
            ->selectButton('Submit')
            ->form();
        // set the bad login values
        $form['_username'] = 'neil';
        $form['_password'] = 'Heythere!';
        // submit the form
//        var_dump($form->getValues());
        $crawler = $client->submit($form);
        $crawler = $client->followRedirect(true);
        $this->assertTrue($crawler->filter('html:contains("Username")')->count() > 0);

    }
}
