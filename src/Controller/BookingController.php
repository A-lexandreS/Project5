<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Event;
use App\Entity\Registration;
use App\Form\CommentType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/booking/{id}')]
    public function booking(Request $request, EntityManagerInterface $em, Event $event): Response
    {
        $booking = new Registration();
        $booking->setEvent($event);
        $formBooking = $this->createForm(RegistrationType::class, $booking)->handleRequest($request);
        if ($formBooking->isSubmitted() && $formBooking->isValid() && $this->isGranted('register', $event)) {
            $em->persist($booking);

            $em->flush();

            return $this->redirectToRoute('app_booking_booking', ['id' => $event->getId()]);
        }

        $comment = new Comment();
        $comment->setEvent($event);
        $formComment = $this->createForm(CommentType::class, $comment)->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $em->persist($comment);

            $em->flush();

            return $this->redirectToRoute('app_booking_booking', ['id' => $event->getId()]);
        }
        $comments = $event->getComments();

        return $this->renderForm('booking/booking.html.twig', [
            'formBooking' => $formBooking,
            'formComment' => $formComment,
            'event' => $event,
            'comments' => $comments,
        ]);
    }

    #[Route('/booking/delete-registration/{id}')]
    public function deleteRegistration(EntityManagerInterface $em, int $id)
    {
        $registration = $em->getRepository(Registration::class)->find($id);
        $em->remove($registration);
        $em->flush();

        return $this->redirectToRoute('app_default_dashboard');
    }

    #[Route('/booking/delete-comment/{id}')]
    public function deleteComment(EntityManagerInterface $em, int $id)
    {
        $comment = $em->getRepository(Comment::class)->find($id);
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('app_default_dashboard');
    }
}
