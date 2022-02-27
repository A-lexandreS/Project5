<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/reservation', name: 'reservation')]
    public function post(): Response
    {
        return $this->render('post/reservation.html.twig', []);
    }
    #[Route('/gallery', name: 'gallery')]
    public function posts(): Response
    {
        return $this->render('post/gallery.html.twig', []);
    }
}
