<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/')]
    public function home(): Response
    {
        return $this->render('default/home.html.twig', []);
    }
    #[Route('/contact')]
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig', []);
    }
    #[Route('/events')]
    public function events(): Response
    {
        return $this->render('default/events.html.twig', []);
    }
    #[Route('/dashboard')]
    public function dashboard(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Event::class);
        $events = $repo->findAll();
        return $this->render('default/dashboard.html.twig', ['events' => $events]);
    }
}

