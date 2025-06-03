<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Screening;
use App\Form\MovieTypeForm;
use App\Form\ScreeningTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/worker')]
final class WorkerController extends AbstractController
{
    #[Route('/', name: 'app_worker')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('worker/index.html.twig', [
            'controller_name' => 'WorkerController',
        ]);
    }

    #[Route('/create-movie', name: 'app_create_movie')]
    public function createMovie(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $movie = new Movie();
        $form = $this->createForm(MovieTypeForm::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($movie);
            $entityManager->flush();

            $this->addFlash('success', 'Movie created successfully!');
            return $this->redirectToRoute('app_worker');
        }

        return $this->render('worker/create_movie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/create-screening', name: 'app_create_screening')]
    public function createScreening(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $screening = new Screening();
        $form = $this->createForm(ScreeningTypeForm::class, $screening);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($screening);
            $entityManager->flush();

            $this->addFlash('success', 'Screening created successfully!');
            return $this->redirectToRoute('app_worker');
        }

        return $this->render('worker/create_screening.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}