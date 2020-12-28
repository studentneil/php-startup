<?php

namespace App\Controller;

use App\Domain\Search;
use App\Form\SearchFormType;
use Discogs\ClientFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/admin/search", name="search")
     */
    public function index(Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchFormType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Search $search */
            $search = $form->getData();
            $client = $this->getDiscogsClient();
            $response = $client->search(
                [
                    'type' => 'release',
                    'release_title' => $search->getTitle(),
                    'catno' => $search->getCatalogNumber(),
                    'format' => 'vinyl'
                ]);

            return $this->render('backend/SearchResults.html.twig', [
                'discogsResults' => $response['results']
            ]);
        }

        return $this->render('backend/SearchForm.html.twig', [
            'controller_name' => 'SearchController',
            'form' => $form->createView()
        ]);
    }

    private function getDiscogsClient()
    {
        return ClientFactory::factory([
            'defaults' => [
                'headers' => [
                    'User-Agent' => 'vinyl rug/0.1 +https://www.therecordbox.ie'
                ],
                'query' => [
                    'token' => $_ENV['DISCOGS_TOKEN']
                ],
            ]
        ]);
    }
}
