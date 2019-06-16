<?php
declare(strict_types=1);

namespace VinylStore\Controllers;

use Discogs\ClientFactory;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use VinylStore\Forms\SearchFormType;

class SearchDiscogsController
{
    public function searchAction(Application $app)
    {
        $client = ClientFactory::factory([
            'defaults' => [
                'headers' => [
                    'User-Agent' => 'vinyl rug/0.1 +https://www.therecordbox.ie'
                ],
                'query' => [
                    'token' => $app['config']['discogs']['token']
                ],

            ]
        ]);
        $response = $client->search(
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
            $data = $form->getData();
        }

        return $app['twig']->render('backend/SearchForm.html.twig', [
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),
        ]);
    }
}