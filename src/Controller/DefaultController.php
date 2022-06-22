<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\CommentRepository;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/')]
    public function home(EventRepository $eventRepo): Response
    {
        $lastEvents = $eventRepo->findLastEvents();

        return $this->render('default/home.html.twig', ['lastEvents' => $lastEvents]);
    }

    #[Route('/contact')]
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig', []);
    }

    #[Route('/events')]
    public function events(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Event::class);
        $events = $repo->findAll();

        return $this->render('default/events.html.twig', ['events' => $events]);
    }

    #[Route('/dashboard')]
    public function dashboard(EventRepository $eventRepo, RegistrationRepository $registrationRepository, CommentRepository $commentRepository): Response
    {
        $events = $eventRepo->findAll();
        $registrations = $registrationRepository->findAll();
        $comments = $commentRepository->findAll();

        return $this->render('default/dashboard.html.twig', ['events' => $events, 'registrations' => $registrations, 'comments' => $comments]);
    }

    #[Route('/siteMap')]
    public function siteMap()
    {
        return $this->render('default/siteMap.html.twig', []);
    }
}
