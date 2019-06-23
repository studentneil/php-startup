<?php
declare(strict_types=1);

namespace VinylStore\Controllers;

use Discogs\ClientFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Command\AbstractClient;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use VinylStore\Forms\SearchFormType;

class SearchDiscogsController
{
    public function searchAction(Request $request, Application $app)
    {

        $response = $this->client->search(
            [
                'type' => 'release',
                'release_title' => 'nevermind',
                'catno' => 'DGC 24425'
            ]);

        foreach ($response['results'] as $result) {
            var_dump($result['id']);
        }
    }

    public function searchFormAction(Request $request, Application $app)
    {
        $data = [];
        $form = $app['form.factory']
            ->createBuilder(SearchFormType::class, $data)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $formData = $form->getData();
            $discogsClient = $this->getClient($app);
            $response = $discogsClient->search(
                [
                    'type' => 'release',
                    'release_title' => $formData['title'],
                    'catalogueNumber' => $formData['catalogue_number'],
                    'format' => 'vinyl'
                ]);

            return $app['twig']->render('backend/SearchResults.html.twig', [
                'user' => $app['session']->get('user'),
                'discogsResults' => $response['results']
            ]);
        }

        return $app['twig']->render('backend/SearchForm.html.twig', [
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),
        ]);
    }

    public function resultAction(Request $request, Application $app, $id)
    {
        $discogsClient = $this->getClient($app);
        $response = $discogsClient->getRelease(
            [
                'id' => $id
            ]);

        return $app['twig']->render('backend/discogsResult.html.twig', [
            'user' => $app['session']->get('user'),
            'result' => $response
        ]);
    }

    /**
     * @param \Silex\Application $app
     * @return  GuzzleClient
     */
    private function getClient(Application $app): GuzzleClient
    {
        return ClientFactory::factory([
            'defaults' => [
                'headers' => [
                    'User-Agent' => 'vinyl rug/0.1 +https://www.therecordbox.ie'
                ],
                'query' => [
                    'token' => $app['config']['discogs']['token']
                ],

            ]
        ]);
    }
}