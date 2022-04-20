<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Event;
use App\Entity\Comment;
use App\Entity\Registration;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\CommentType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BookingController extends AbstractController
{
    #[Route('/booking/{id}')]
    public function booking(Request $request, EntityManagerInterface $em, Event $event): Response
    {
        
        $booking = new Registration($event);
        $formBooking = $this->createForm(RegistrationType::class, $booking)->handleRequest($request);

        if ($formBooking->isSubmitted() && $formBooking->isValid()) 
        {
            $em->persist($booking);

            $em->flush();
            return $this->redirectToRoute('app_booking_booking');
        }

        $comment = new Comment($event);
        $formComment = $this->createForm(CommentType::class, $comment)->handleRequest($request);
        
        if ($formComment->isSubmitted() && $formComment->isValid()) 
        {
            $em->persist($comment);

            $em->flush();
            return $this->redirectToRoute('app_booking_booking');
        }
        
        return $this->renderForm('booking/booking.html.twig', [
            'formBooking' => $formBooking,
            'formComment' => $formComment,
            'event' => $event,
            'comment' => $comment

        ]);
    }
}
