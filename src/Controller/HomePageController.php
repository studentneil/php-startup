<?php

namespace App\Controller;

use App\Domain\Genre;
use App\Repository\ReleaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/home", name="home_page")
     */
    public function index(ReleaseRepository $releaseRepository): Response
    {
        $electronicReleases = $releaseRepository->findReleasesByGenre(Genre::ELECTRONIC);
        $rockReleases = $releaseRepository->findReleasesByGenre(Genre::ROCK);

        return $this->render('frontend/home.html.twig', [
            'controller_name' => 'HomePageController',
            'electronic_releases' => $electronicReleases,
            'rock_releases' => $rockReleases
        ]);
    }
}
