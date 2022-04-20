<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/')]
    public function home(EventRepository $repo): Response
    {
        $lastEvents = $repo->findLastEvents();
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
    public function dashboard(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Event::class);
        $events = $repo->findAll();
        return $this->render('default/dashboard.html.twig', ['events' => $events]);
    }
}

