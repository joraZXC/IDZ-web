<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VisitorController extends AbstractController
{
    #[Route('/visitor', name: 'app_visitor')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('visitor/index.html.twig', [
            'controller_name' => 'VisitorController',
        ]);
    }

    #[Route('/visitor/book', name: 'app_book_ticket')]
    public function bookTicket(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $ticket = new Ticket();
        $form = $this->createForm(TicketTypeForm::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setBookingTime(new \DateTime());
            $screening = $ticket->getScreening();
            $seatsCount = $ticket->getSeatsCount();
            
            if ($screening->getAvailableSeats() >= $seatsCount) {
                $ticket->setTotalPrice((string) ($seatsCount * (float) $screening->getPrice()));
                $screening->setAvailableSeats($screening->getAvailableSeats() - $seatsCount);

                $entityManager->persist($ticket);
                $entityManager->persist($screening);
                $entityManager->flush();

                $this->addFlash('success', 'Ticket booked successfully!');
                return $this->redirectToRoute('app_visitor_tickets');
            } else {
                $this->addFlash('error', 'Not enough available seats.');
            }
        }

        return $this->render('visitor/book.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/visitor/tickets', name: 'app_visitor_tickets')]
    public function viewTickets(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $userEmail = $this->getUser()->getEmail();
        $tickets = $entityManager->getRepository(Ticket::class)->findBy(['customerEmail' => $userEmail]);

        return $this->render('visitor/tickets.html.twig', [
            'tickets' => $tickets,
        ]);
    }
}