<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ReleaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index(ReleaseRepository $releaseRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $usersReleases = $user->getReleases();

        return $this->render('backend/dashboard.html.twig', [
            'controller_name' => 'AdminDashboardController',
            'releases' => $usersReleases
        ]);
    }
}
