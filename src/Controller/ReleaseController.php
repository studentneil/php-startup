<?php

namespace App\Controller;

use App\Entity\Release;
use App\Form\ReleaseType;
use App\Repository\ReleaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/release")
 */
class ReleaseController extends AbstractController
{
    /**
     * @Route("/", name="release_index", methods={"GET"})
     */
    public function index(ReleaseRepository $releaseRepository): Response
    {
        return $this->render('release/index.html.twig', [
            'releases' => $releaseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="release_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
//        var_dump($request->get('format'));die();
        $release = new Release();
        $release->setTitle($request->get('title') ?: null);
        $release->setBarcode($request->get('barcode') ?: null);
        $release->setGenre($request->get('genre') ?: null);
        $release->setReleaseDate(
            $request->get('released') != '__BLANK__'
                ? new \DateTime($request->get('released'))
                : null
        );
        $release->setArtist($request->get('artist') ?: null);
        $release->setCatalogNumber($request->get('catalogNumber') ?: null);
        $release->setLabel($request->get('label') ?: null);
        $release->setFormat($request->get('format') ?: null);

        $form = $this->createForm(ReleaseType::class, $release);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $release->setUser($this->getUser());
            $release->setAddedDate(new \DateTime());
            $entityManager->persist($release);
            $entityManager->flush();

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('release/new.html.twig', [
            'release' => $release,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="release_show", methods={"GET"})
     */
    public function show(Release $release): Response
    {
        return $this->render('release/show.html.twig', [
            'release' => $release,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="release_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Release $release): Response
    {
        $form = $this->createForm(ReleaseType::class, $release);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('release/edit.html.twig', [
            'release' => $release,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="release_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Release $release): Response
    {
        if ($this->isCsrfTokenValid('delete'.$release->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($release);
            $entityManager->flush();
        }

        return $this->redirectToRoute('release_index');
    }
}
